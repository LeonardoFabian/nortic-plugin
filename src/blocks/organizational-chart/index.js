import { registerBlockType } from "@wordpress/blocks";
import { render, useEffect, useState } from "@wordpress/element";
import { useSelect } from "@wordpress/data";
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import {
  Spinner,
  PanelBody,
  TextControl,
  SelectControl,
} from "@wordpress/components";
import { Tree, TreeNode } from "react-organizational-chart";
import styled from "styled-components";
import { __ } from "@wordpress/i18n";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

const StyledNode = styled.div`
  padding: 5px 10px;
  border-radius: 8px;
  display: inline-block;
  border: 1px solid #000;
  background-color: #fff;
`;

const renderNode = (dependency) => (
  <TreeNode
    label={<StyledNode>{dependency.title}</StyledNode>}
    key={dependency.id}
  >
    {dependency.children && dependency.children.map(renderNode)}
  </TreeNode>
);

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes }) {
    const { endPoint, rootParentId } = attributes;
    const [treeData, setTreeData] = useState(null);
    const blockProps = useBlockProps();

    useEffect(() => {
      if (!rootParentId || rootParentId === 0) return; // evita hacer el fetch si no se ha seleccionado un nodo

      fetch(`${endPoint}/${rootParentId}`)
        .then((response) => response.json())
        .then((data) => {
          setTreeData(data);
          console.log("Fetched Tree Data:", data);
        })
        .catch((error) => {
          console.error("Error fetching data:", error);
        });
    }, [rootParentId]);

    const allDependencies = useSelect((select) => {
      return select("core").getEntityRecords("postType", "dependency", {
        per_page: -1,
        orderby: "title",
        order: "asc",
      });
    }, []);

    console.log("All Dependencies:", allDependencies);

    const selectedDependencies = useSelect(
      (select) => {
        // if (!rootParentId || rootParentId === 0) return null; // evita hacer el fetch si no se ha seleccionado un nodo

        return select("core").getEntityRecords("postType", "dependency", {
          per_page: -1,
          parent: rootParentId,
          orderby: "title",
          order: "asc",
        });
      },
      [rootParentId]
    );

    console.log("Selected Dependency ID:", selectedDependencies);

    // if (!selectedDependencies) {
    //   return <Spinner />;
    // }

    return (
      <>
        <InspectorControls>
          <PanelBody
            title={__("Organizational Chart Settings", block.textdomain)}
          >
            <SelectControl
              label={__("Root Parent", block.textdomain)}
              value={rootParentId}
              options={[
                { value: 0, label: __("-- Root --", block.textdomain) },
                ...allDependencies?.map((dependency) => ({
                  value: dependency?.id,
                  label: dependency?.title?.rendered,
                })),
              ]}
              onChange={(value) =>
                setAttributes({ rootParentId: parseInt(value) })
              }
            />
          </PanelBody>
        </InspectorControls>
        {treeData ? (
          <div {...blockProps}>
            <Tree label={<StyledNode>{treeData?.title?.rendered}</StyledNode>}>
              {treeData?.children?.map(renderNode)}
            </Tree>
          </div>
        ) : (
          <p>{__("Add a valid root parent ID", block.textdomain)}</p>
        )}
      </>
    );
  },
  save() {
    return null; // This block is dynamic, so we return null for the save function
  },
});
