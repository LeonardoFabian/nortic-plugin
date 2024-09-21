import { useState, useEffect } from "@wordpress/element";

const Sidebar = ({ show }) => {
  const [showSidebar, setShowSidebar] = useState(show);

  const handleShowSidebar = () => {
    setShowSidebar(!showSidebar);
  };

  console.log(showSidebar);

  return (
    <>
      <div
        className={`top-0 right-0 w-25vw bg-white p-8 mt-10 text-white fixed h-full shadow-lg z-40 ease-in-out duration-300 ${
          showSidebar ? "translate-x-0" : "translate-x-full"
        }`}
      >
        <div className="flex items-center justify-end">
          <button
            className="flex text-2xl text-slate-700 items-center cursor-pointer"
            onClick={handleShowSidebar}
          >
            <i className="bi bi-x-lg"></i>
          </button>
        </div>
        <h3 className="mt-10 font-semibold text-slate-700">I am a Sidebar</h3>
      </div>
    </>
  );
};

export default Sidebar;
