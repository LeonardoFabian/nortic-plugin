import { useState } from "react";
import { createRoot } from "react-dom/client";
import { Tree, TreeNode } from "react-organizational-chart";
import styled from "styled-components";

const StyledNode = styled.div`
  padding: 5px 10px;
  border-radius: 8px;
  display: inline-block;
  border: 1px solid #000;
  background-color: #fff;
  cursor: pointer;
  &:hover {
    color: #003876;
  }
`;

// estilo para el modal
const ModalOverlay = styled.div`
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  z-index: 999;
`;

const ModalContent = styled.div`
  position: fixed;
  top: 50%;
  left: 50%;
  width: 90%;
  max-width: 600px;
  max-height: 80vh;
  overflow-y: auto;
  transform: translate(-50%, -50%);
  background: white;
  padding: 20px;
  border-radius: 10px;
`;

function OrganizationalChart({ treeData }) {
  const [activeNode, setActiveNode] = useState(null);

  const renderNode = (node) => {
    if (!node) return null;

    // forzar a children para que sea un array
    const children = Array.isArray(node.children)
      ? node.children
      : node.children
      ? [node.children]
      : [];

    return (
      <TreeNode
        label={
          <StyledNode onClick={() => setActiveNode(node)}>
            {node.title}
          </StyledNode>
        }
        key={node.id}
      >
        {children.map(renderNode)}
      </TreeNode>
    );
  };

  return (
    <>
      <Tree
        label={
          <StyledNode onClick={() => setActiveNode(treeData)}>
            {treeData.title}
          </StyledNode>
        }
      >
        {(Array.isArray(treeData.children) ? treeData.children : []).map(
          renderNode
        )}
      </Tree>

      {activeNode && (
        <ModalOverlay onClick={() => setActiveNode(null)}>
          <ModalContent onClick={(e) => e.stopPropagation()}>
            <h2>{activeNode.title}</h2>
            <div
              dangerouslySetInnerHTML={{ __html: activeNode.content || "" }}
            />
            <button onClick={() => setActiveNode(null)}>Cerrar</button>
          </ModalContent>
        </ModalOverlay>
      )}
    </>
  );
}

// {
//   activeNode && (
//     <div className="active-node-modal">
//       <h2>{activeNode.title}</h2>
//       <div dangerouslySetInnerHTML={{ __html: activeNode.content }} />
//       <button onClick={() => setActiveNode(null)}>Cerrar</button>
//     </div>
//   );
// }

window.addEventListener("DOMContentLoaded", () => {
  const container = document.querySelector(
    ".wp-block-nortic-plugin-organizational-chart"
  );
  if (!container) return;

  const treeDataRaw = container.getAttribute("data-tree");
  if (!treeDataRaw) return;

  let treeData;
  try {
    treeData = JSON.parse(treeDataRaw);
  } catch (error) {
    console.error("Error parsing tree data:", error);
    return;
  }

  const root = createRoot(container);
  root.render(<OrganizationalChart treeData={treeData} />);
  // root.render(
  //   <Tree label={<StyledNode>{treeData.title}</StyledNode>}>
  //     {(Array.isArray(treeData.children) ? treeData.children : []).map(
  //       renderNode
  //     )}
  //   </Tree>
  // );
});
