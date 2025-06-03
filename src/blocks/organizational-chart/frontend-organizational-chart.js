import { useEffect, useState } from "react";
import { createRoot } from "react-dom/client";
import { Tree, TreeNode } from "react-organizational-chart";
import styled from "styled-components";

const StyledNode = styled.div`
  padding: 5px 10px;
  border-radius: 8px;
  display: inline-block;
  border: 1px solid #000;
  background-color: #fff;
`;

const renderNode = (node) => {
  if (!node) return null;

  // forzar a children para que sea un array
  const children = Array.isArray(node.children)
    ? node.children
    : node.children
    ? [node.children]
    : [];

  return (
    <TreeNode label={<StyledNode>{node.title}</StyledNode>} key={node.id}>
      {children.map(renderNode)}
    </TreeNode>
  );
};

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
  root.render(
    <Tree label={<StyledNode>{treeData.title}</StyledNode>}>
      {(Array.isArray(treeData.children) ? treeData.children : []).map(
        renderNode
      )}
    </Tree>
  );
});
