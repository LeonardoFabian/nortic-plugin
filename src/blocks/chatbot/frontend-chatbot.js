import { render, useState, useRef, useEffect } from "@wordpress/element";
import apiFetch from "@wordpress/api-fetch";
import { Spinner } from "@wordpress/components";
import { __ } from "@wordpress/i18n";

function ChatBot(props) {
  const [messages, setMessages] = useState([]);
  const [responseId, setResponseId] = useState(null);
  const [sizeClass, setSizeClass] = useState("");
  const [result, setResult] = useState(false);
  const chatRef = useRef(null);
  const fullSizeBtnRef = useRef(null);
  const exitFullSizeBtnRef = useRef(null);
  const chatContainerRef = useRef(null);

  //   const openaiConfiguration = new Configuration({
  //     apiKey: "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",
  //   });
  //   const openaiApi = new OpenAIApi(openaiConfiguration);

  useEffect(() => {
    //   console.log("Messages changed");
    chatRef.current.scrollTo(0, chatRef.current.scrollHeight);
  }, [messages]);

  const toggleDisplayChat = () => {
    chatContainerRef.current.style.display =
      chatContainerRef.current.style.display == "" ||
      chatContainerRef.current.style.display == "none"
        ? "block"
        : "none";
  };

  // maximize chat
  const handleFullScreen = () => {
    chatContainerRef.current.classList.add("chat-fullscreen");
    fullSizeBtnRef.current.style.display = "none";
    fullSizeBtnRef.current.classList.remove("flex");
    exitFullSizeBtnRef.current.style.display = "flex";
    exitFullSizeBtnRef.current.classList.add("flex");
    // setSizeClass("chat-fullscreen");
  };

  // minimize chat
  const handleExitFullScreen = () => {
    chatContainerRef.current.classList.remove("chat-fullscreen");
    fullSizeBtnRef.current.style.display = "flex";
    fullSizeBtnRef.current.classList.add("flex");
    exitFullSizeBtnRef.current.style.display = "none";
    exitFullSizeBtnRef.current.classList.remove("flex");
  };

  const [promptInput, setPromptInput] = useState();

  const onSubmit = async (prompt) => {
    if (prompt.trim().length === 0) {
      return;
    }

    const date = new Date().toISOString();

    setMessages((messages) => {
      return [
        ...messages,
        {
          session: date,
          messageClasses: "user-chat-message",
          avatar: "bi-chat-left-dots",
          text: prompt,
          message_date: date,
        },
      ];
    });

    // response with completion endpoint
    const response = await apiFetch({
      // http://wordpressmt.local/np/v1/completion
      path: "np/v1/completion",
      method: "POST",
      data: {
        text: prompt,
        session: date,
        message_date: date,
        response_id: responseId,
      },
    });

    // // response with completion/create endpoint
    // const response = await apiFetch({
    //   // http://wordpressmt.local/np/v1/completion/create
    //   path: "np/v1/create-completion",
    //   method: "POST",
    //   data: JSON.stringify({ prompt }),
    // });

    // const json = await response.json();

    if (response.status == 2) {
      setResult(true);
      setMessages((messages) => {
        return [
          ...messages,
          {
            session: "chatbot-session",
            messageClasses: "ia-chat-message font-semibold",
            avatar: "bi-robot",
            text: "Job: " + response.result,
            message_date: new Date().toISOString(),
          },
        ];
      });
      setResponseId(response?.responseID);
    } else {
      console.error(response?.error?.message);
    }

    // if (response.ok) {
    //   setResult(true);
    //   setMessages((messages) => {
    //     return [
    //       ...messages,
    //       {
    //         session: "chatbot-session",
    //         messageClasses: "ia-chat-message font-semibold",
    //         avatar: "bi-robot",
    //         text: json.result,
    //         message_date: new Date().toISOString(),
    //       },
    //     ];
    //   });
    // } else {
    //   console.error(json?.error?.message);
    // }

    //   alert(prompt);
  };

  return (
    <>
      <div
        ref={chatContainerRef}
        class="chatbot-container rounded-lg shadow-lg p-4"
        style={{ display: "none" }}
      >
        <div id="chatbot-options" class="flex items-center justify-end">
          <a
            ref={fullSizeBtnRef}
            onClick={handleFullScreen}
            id="chatbot-allow-fullscreen-button"
            class="cursor-pointer items-center justify-center rounded-lg w-8 h-8 shadow-white"
            style={{ display: "block" }}
          >
            <i class="bi bi-arrows-fullscreen"></i>
          </a>
          <a
            ref={exitFullSizeBtnRef}
            onClick={handleExitFullScreen}
            id="chatbot-minimize-button"
            class="cursor-pointer items-center justify-center rounded-lg w-8 h-8 shadow-white"
            style={{ display: "none" }}
          >
            <i class="bi bi-fullscreen-exit"></i>
          </a>
        </div>
        <div class="chatbot-header p-4 rounded-lg mb-4 text-sm flex items-center gap-4 font-semibold">
          <span class="chatbot-avatar flex items-center justify-center rounded-full py-2 px-3">
            <i class="bi bi-robot text-2xl text-white"></i>
          </span>
          {__(
            "Hi, I'm Job, your job assistant, how can I help you?",
            "nortic-plugin"
          )}
        </div>
        <div
          ref={chatRef}
          class="chat-container flex flex-col gap-4 my-4 w-full h-64 p-8 overflow-scroll"
        >
          {messages.map((message) => {
            return (
              <>
                <div
                  key={message.message_date}
                  data-session={message.session}
                  class={`chat-message flex flex-row items-start bg-white ${message.messageClasses} border border-gray-200 py-2 px-4 rounded-lg`}
                >
                  <span class="user-avatar rounded-full bg-gray-500 py-2 px-3 mr-4">
                    <i class={`bi ${message.avatar}`}></i>
                  </span>
                  <div
                    class="user-message text-sm"
                    style={{
                      wordWrap: "break-word",
                      width: "80%",
                      display: "inline-block",
                    }}
                  >
                    {message.text}
                  </div>
                </div>
                <time class="chat-message-time">{message.message_date}</time>
                {!result && <Spinner />}
              </>
            );
          })}
        </div>
        {/* {promptInput} */}
        <div class="relative w-full flex items-center mt-4">
          <textarea
            rows={2}
            onChange={(e) => setPromptInput(e.target.value)}
            onKeyDown={(e) => {
              if (e.key === "Enter") {
                // console.log("Pressing Enter key...");
                e.preventDefault();
                onSubmit(promptInput);
                setPromptInput("");
                setResult(false);
              }
            }}
            class="w-full p-2.5 text-sm text-gray-900 bg-slate-50 rounded-lg border border-gray-300"
            value={promptInput}
            onSubmit={onSubmit}
          />
        </div>
      </div>
      <div class="relative w-full flex items-center justify-end mt-4">
        <a
          onClick={toggleDisplayChat}
          id="floating-chatbot-button"
          class="floating-chatbot-button cursor-pointer flex items-center justify-center rounded-full w-14 h-14 shadow-white"
        >
          <i class="bi bi-chat-dots-fill text-4xl text-white"></i>
        </a>
      </div>
    </>
  );
}

document.addEventListener("DOMContentLoaded", () => {
  const chatBot = document.getElementById("chatbot");
  const chatContainer = document.querySelector(".chatbot-container");
  const chatBox = document.getElementById("chat-box");
  const chatBtn = document.getElementById("floating-chatbot-button");

  render(<ChatBot />, chatBot);

  //   chatBtn.addEventListener("click", (e) => {
  //     console.log("click");
  //     e.preventDefault();

  //     chatContainer.style.display =
  //       chatContainer.style.display == "" || chatContainer.style.display == "none"
  //         ? "block"
  //         : "none";
  //   });
});
