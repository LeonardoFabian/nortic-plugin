import { registerPlugin } from "@wordpress/plugins";
import { PluginSidebar } from "@wordpress/edit-post";
import { __ } from "@wordpress/i18n";
import { useSelect, useDispatch } from "@wordpress/data";
import {
  PanelBody,
  Icon,
  TextControl,
  TextareaControl,
  __experimentalSurface as Surface,
  __experimentalHStack as HStack,
  __experimentalText as Text,
} from "@wordpress/components";

registerPlugin("nortic-plugin-sidebar", {
  render() {
    const {
      phone,
      email,
      location,
      full_name,
      job_title,
      biography,
      mobile,
      facebook,
      instagram,
      twitter,
      linkedin,
    } = useSelect((select) => {
      return select("core/editor").getEditedPostAttribute("meta");
    }, []);

    const postType = useSelect(
      (select) => select("core/editor").getCurrentPostType(),
      []
    );

    const { editPost } = useDispatch("core/editor");

    return (
      <PluginSidebar
        name="nortic_plugin_team_sidebar"
        icon="businessman"
        title={__("Team Settings", "nortic-plugin")}
      >
        <PanelBody title={__("Information", "nortic-plugin")}>
          <TextControl
            label={__("Full Name", "nortic-plugin")}
            value={full_name}
            onChange={(full_name) =>
              editPost({
                meta: {
                  full_name,
                },
              })
            }
          />
          <TextControl
            label={__("Job Title", "nortic-plugin")}
            value={job_title}
            onChange={(job_title) =>
              editPost({
                meta: {
                  job_title,
                },
              })
            }
          />
          <TextareaControl
            label={__("Biography", "nortic-plugin")}
            value={biography}
            onChange={(biography) =>
              editPost({
                meta: {
                  biography,
                },
              })
            }
          />
        </PanelBody>
        <PanelBody title={__("Contact", "nortic-plugin")}>
          {postType !== "team" && (
            <>
              <HStack
                alignment="center"
                justify="start"
                spacing="3"
                style={{
                  marginBottom: ".5rem",
                }}
              >
                <Icon icon="location" />
                <Text>{__("Location", "nortic-plugin")}</Text>
              </HStack>
              <TextareaControl
                value={location}
                onChange={(location) =>
                  editPost({
                    meta: {
                      location,
                    },
                  })
                }
              />
            </>
          )}
          <HStack
            alignment="center"
            justify="start"
            spacing="3"
            style={{
              marginBottom: ".5rem",
            }}
          >
            <Icon icon="phone" />
            <Text>{__("Phone Number", "nortic-plugin")}</Text>
          </HStack>
          <TextControl
            // label={__("Phone Number", "nortic-plugin")}
            value={phone}
            onChange={(phone) =>
              editPost({
                meta: {
                  phone,
                },
              })
            }
          />
          {postType === "team" && (
            <>
              <HStack
                alignment="center"
                justify="start"
                spacing="3"
                style={{
                  marginBottom: ".5rem",
                }}
              >
                <Icon icon="smartphone" />
                <Text>{__("Mobile Number", "nortic-plugin")}</Text>
              </HStack>
              <TextControl
                value={mobile}
                onChange={(mobile) =>
                  editPost({
                    meta: {
                      mobile,
                    },
                  })
                }
              />
            </>
          )}
          <HStack
            alignment="center"
            justify="start"
            spacing="3"
            style={{
              marginBottom: ".5rem",
            }}
          >
            <Icon icon="email" />
            <Text>{__("Email", "nortic-plugin")}</Text>
          </HStack>
          <TextControl
            value={email}
            onChange={(email) =>
              editPost({
                meta: {
                  email,
                },
              })
            }
          />
        </PanelBody>
        <PanelBody title={__("Social accounts", "nortic-plugin")}>
          {/* linkedin */}
          <HStack
            alignment="center"
            justify="start"
            spacing="3"
            style={{
              marginBottom: ".5rem",
            }}
          >
            <Icon icon="linkedin" />
            <Text>{__("LinkedIn", "nortic-plugin")}</Text>
          </HStack>
          <TextControl
            value={linkedin}
            onChange={(linkedin) =>
              editPost({
                meta: {
                  linkedin,
                },
              })
            }
          />
          {/* END linkedin */}
          {/* twitter */}
          <HStack
            alignment="center"
            justify="start"
            spacing="3"
            style={{
              marginBottom: ".5rem",
            }}
          >
            <Icon icon="twitter" />
            <Text>{__("Twitter", "nortic-plugin")}</Text>
          </HStack>
          <TextControl
            value={twitter}
            onChange={(twitter) =>
              editPost({
                meta: {
                  twitter,
                },
              })
            }
          />
          {/* END twitter */}
          {/* facebook */}
          <HStack
            alignment="center"
            justify="start"
            spacing="3"
            style={{
              marginBottom: ".5rem",
            }}
          >
            <Icon icon="facebook" />
            <Text>{__("Facebook", "nortic-plugin")}</Text>
          </HStack>
          <TextControl
            value={facebook}
            onChange={(facebook) =>
              editPost({
                meta: {
                  facebook,
                },
              })
            }
          />
          {/* END facebook */}
          {/* instagram */}
          <HStack
            alignment="center"
            justify="start"
            spacing="3"
            style={{
              marginBottom: ".5rem",
            }}
          >
            <Icon icon="instagram" />
            <Text>{__("Instagram", "nortic-plugin")}</Text>
          </HStack>
          <TextControl
            value={instagram}
            onChange={(instagram) =>
              editPost({
                meta: {
                  instagram,
                },
              })
            }
          />
          {/* END instagram */}
        </PanelBody>
      </PluginSidebar>
    );
  },
});
