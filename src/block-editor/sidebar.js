// import { registerPlugin } from "@wordpress/plugins";
// import { PluginSidebar } from "@wordpress/edit-post";
// import { __ } from "@wordpress/i18n";
// import { useSelect, useDispatch } from "@wordpress/data";
// import {
//   PanelBody,
//   Icon,
//   TextControl,
//   __experimentalHStack as HStack,
// } from "@wordpress/components";

// registerPlugin("nortic-plugin-sidebar", {
//   render() {
//     const { phone, email } = useSelect((select) => {
//       return select("core/editor").getEditedPostAttribute("meta");
//     }, []);

//     const { editPost } = useDispatch("core/editor");

//     return (
//       <PluginSidebar
//         name="nortic_plugin_sidebar"
//         icon="menu-alt"
//         title={__("Team Metadata", "nortic-plugin")}
//       >
//         <PanelBody title={__("Information", "nortic-plugin")}>
//           <HStack>
//             <Icon icon="phone" />
//             <TextControl
//               label={__("Phone Number", "nortic-plugin")}
//               value={phone}
//               onChange={(phone) =>
//                 editPost({
//                   meta: {
//                     phone,
//                   },
//                 })
//               }
//             />
//           </HStack>
//         </PanelBody>
//       </PluginSidebar>
//     );
//   },
// });
