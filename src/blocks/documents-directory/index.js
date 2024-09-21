import { registerBlockType } from "@wordpress/blocks";
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import { useSelect } from "@wordpress/data";
import {
  RangeControl,
  Spinner,
  PanelBody,
  ToggleControl,
  TextareaControl,
  QueryControls,
  RichText,
} from "@wordpress/components";
import { __ } from "@wordpress/i18n";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes }) {
    const { order, orderBy } = attributes;
    const blockProps = useBlockProps();

    return <p>Este block se renderiza en el frontend</p>;
  },
});
