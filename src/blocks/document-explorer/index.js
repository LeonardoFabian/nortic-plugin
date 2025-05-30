import { registerBlockType } from "@wordpress/blocks";
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import { useSelect } from "@wordpress/data";
import { Spinner, PanelBody, SelectControl } from "@wordpress/components";
import { __ } from "@wordpress/i18n";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes }) {
    const { parentId, order, orderBy } = attributes;
    const blockProps = useBlockProps();

    const allFolders = useSelect((select) => {
      return select("core").getEntityRecords("postType", "document", {
        per_page: -1,
        meta_key: "document_type",
        meta_value: "folder",
        orderby: "title",
        order: "asc",
      });
    }, []);

    const documents = useSelect(
      (select) => {
        return select("core").getEntityRecords("postType", "document", {
          per_page: -1,
          parent: parentId,
          orderby: "title",
          order: "asc",
        });
      },
      [parentId]
    );

    if (!documents && !allFolders) {
      return <Spinner />;
    }

    return (
      <>
        <InspectorControls>
          <PanelBody title={__("Document Root", block.textdomain)}>
            <SelectControl
              label={__("Select Root Folder", block.textdomain)}
              value={parentId}
              options={[
                { value: 0, label: __("-- Root --", block.textdomain) },
                ...allFolders?.map((folder) => ({
                  value: folder.id,
                  label: folder.title.rendered,
                })),
              ]}
              onChange={(value) => setAttributes({ parentId: parseInt(value) })}
            />
          </PanelBody>
        </InspectorControls>
        {documents?.length > 0 ? (
          <div {...blockProps}>
            <ul className="document-explorer-list">
              {(documents || []).map((doc) => (
                <DocumentItem key={doc.id} doc={doc} />
              ))}
            </ul>
          </div>
        ) : (
          <p>{__("No documents found", block.textdomain)}</p>
        )}
      </>
    );
  },
  save() {
    return null;
  },
});

function DocumentItem({ doc }) {
  const meta = doc.meta || {};
  const isFolder = meta.document_type === "folder";
  const isLink = meta.document_type === "external_link";
  const isFile = meta.document_type === "file";
  const isNote = meta.document_type === "note";

  return (
    <li className={`document-explorer-item ${isFolder ? "folder" : "file"}`}>
      {isFolder ? (
        <strong>{doc.title.rendered}</strong>
      ) : isLink ? (
        <a
          href={meta.document_external_url}
          target="_blank"
          rel="noopener noreferrer"
        >
          {doc.title.rendered}
        </a>
      ) : isNote ? (
        <p>{meta.note}</p>
      ) : isFile ? (
        <>
          <span>{doc.title.rendered}</span>
          <a href={meta.file_url} download className="download-button">
            {__("Download", block.textdomain)}
          </a>
        </>
      ) : null}
    </li>
  );
}
