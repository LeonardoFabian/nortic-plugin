import { registerBlockType } from "@wordpress/blocks";
import { useBlockProps, RichText } from "@wordpress/block-editor";
import { useEntityProp } from "@wordpress/core-data";
import { useSelect, withSelect } from "@wordpress/data";
import { __ } from "@wordpress/i18n";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes, context }) {
    const { postId } = context; // Dependency ID

    console.log(postId);

    // const servicesList = withSelect((select) => {
    //   return {
    //     services: select("core").getEntityRecords("postType", "service", {
    //       per_page: 10,
    //       _embed: true,
    //       post_parent: postId,
    //     }),
    //   };
    // }, []);

    // console.log(servicesList);

    return <p>Aqui van los servicios</p>;
  },
});
