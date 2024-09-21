import { registerBlockType } from "@wordpress/blocks";
import { useBlockProps } from "@wordpress/block-editor";
import { __ } from "@wordpress/i18n";
import { useState, useRef, useEffect } from "@wordpress/element";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes }) {
    const blockProps = useBlockProps({
      className:
        "chat w-96 container mx-auto flex flex-col justify-end items-center",
    });

    const [messages, setMessages] = useState([]);
    const chatRef = useRef(null);

    useEffect(() => {
      //   console.log("Messages changed");
      chatRef.current.scrollTo(0, chatRef.current.scrollHeight);
    }, [messages]);

    const [promptInput, setPromptInput] = useState();

    const onSubmit = (prompt) => {
      if (prompt.trim().length === 0) {
        return;
      }

      setMessages((messages) => {
        return [
          ...messages,
          {
            session: "chatbot-session",
            avatar: "bi-chat-left-dots",
            text: prompt,
            message_date: new Date().toISOString(),
          },
        ];
      });

      //   alert(prompt);
    };
    return (
      <div {...blockProps}>
        <div className="hidden chatbot-container w-full rounded-lg shadow-lg p-4">
          <div
            ref={chatRef}
            className="chat-container flex flex-col gap-4 my-4 w-full h-64 p-8 overflow-scroll"
          >
            {messages.map((message) => {
              return (
                <>
                  <div
                    key={message.message_date}
                    data-session={message.session}
                    className="chat-message flex flex-row items-start bg-white border border-gray-200 py-2 px-4 rounded-lg"
                  >
                    <span className="user-avatar rounded-full bg-gray-500 py-2 px-3 mr-4">
                      <i className={`bi ${message.avatar}`}></i>
                    </span>
                    <div className="user-message w-full text-sm">
                      {message.text}
                    </div>
                  </div>
                  <time className="chat-message-time">
                    {message.message_date}
                  </time>
                </>
              );
            })}
            {/* <div className="chat-message flex flex-row items-start bg-white border border-gray-200 p-4 rounded-lg">
            <span className="user-avatar rounded-full bg-gray-500 p-2 mr-4">
              <i class="bi bi-chat-left-dots"></i>
            </span>
            <div className="user-message w-full text-md">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit.
              Pellentesque bibendum est non eros viverra fringilla.
            </div>
          </div>
          <div className="chat-message flex flex-row items-start bg-white border border-gray-200 p-4 rounded-lg">
            <span className="chatbot-avatar rounded-full bg-gray-500 p-2 mr-4">
              <i class="bi bi-robot"></i>
            </span>
            <div className="chatbot-message w-full text-md">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit.
              Pellentesque bibendum est non eros viverra fringilla.
            </div>
          </div> */}
          </div>
          {promptInput}
          <div className="relative w-full flex items-center mt-4">
            <textarea
              rows={2}
              onChange={(e) => setPromptInput(e.target.value)}
              onKeyDown={(e) => {
                if (e.key === "Enter") {
                  // console.log("Pressing Enter key...");
                  e.preventDefault();
                  onSubmit(promptInput);
                  setPromptInput("");
                }
              }}
              className="w-full p-2.5 text-sm text-gray-900 bg-slate-50 rounded-lg border border-gray-300"
              value={promptInput}
              onSubmit={onSubmit}
            />
            {/* <input
            type="text"
            className="block w-full border-gray-300 rounded-lg p-4"
            placeholder={__("Send message", "nortic-plugin")}
          />
          <button
            type="button"
            className="text-white absolute bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-4 py-2 right-2.5"
          >
            {__("Send", "nortic-plugin")}
          </button> */}
          </div>
        </div>
        <div className="relative w-full flex items-center justify-end mt-4">
          <a
            id="floating-chatbot-button"
            className="floating-chatbot-button cursor-pointer flex items-center justify-center rounded-full w-14 h-14 shadow-white"
          >
            <i className="bi bi-robot text-4xl text-white"></i>
          </a>
        </div>
      </div>
    );
  },
});
