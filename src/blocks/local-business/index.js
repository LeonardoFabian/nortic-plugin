import { registerBlockType } from "@wordpress/blocks";
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import {
  TextControl,
  TextareaControl,
  Button,
  PanelBody,
} from "@wordpress/components";
import { __, _x } from "@wordpress/i18n";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes }) {
    const {
      company_name,
      street_address,
      postal_code,
      address_locality,
      telephone,
      fax_number,
      email,
    } = attributes;
    const blockProps = useBlockProps();

    return (
      <>
        <InspectorControls>
          <PanelBody title={__("Local Business Info")}>
            <TextControl
              label={__("Company Name", "nortic-plugin")}
              value={company_name}
              onChange={(company_name) => setAttributes({ company_name })}
            />
            <TextareaControl
              label={__("Street Address", "nortic-plugin")}
              value={street_address}
              onChange={(street_address) => setAttributes({ street_address })}
              rows={3}
            />
            <TextControl
              label={__("Postal Code", "nortic-plugin")}
              value={postal_code}
              onChange={(postal_code) => setAttributes({ postal_code })}
            />
            <TextControl
              label={__("Address Locality", "nortic-plugin")}
              value={address_locality}
              onChange={(address_locality) =>
                setAttributes({ address_locality })
              }
            />
            <TextControl
              label={__("Telephone", "nortic-plugin")}
              value={telephone}
              onChange={(telephone) => setAttributes({ telephone })}
            />
            <TextControl
              label={__("Fax Number", "nortic-plugin")}
              value={fax_number}
              onChange={(fax_number) => setAttributes({ fax_number })}
            />
            <TextControl
              label={__("Email", "nortic-plugin")}
              value={email}
              onChange={(email) => setAttributes({ email })}
            />
          </PanelBody>
        </InspectorControls>
        <div {...blockProps}>
          <TextControl
            label={__("Company Name", "nortic-plugin")}
            value={company_name}
            onChange={(company_name) => setAttributes({ company_name })}
          />
          <TextareaControl
            label={__("Street Address", "nortic-plugin")}
            value={street_address}
            onChange={(street_address) => setAttributes({ street_address })}
            rows={3}
          />
          <TextControl
            label={__("Postal Code", "nortic-plugin")}
            value={postal_code}
            onChange={(postal_code) => setAttributes({ postal_code })}
          />
          <TextControl
            label={__("Address Locality", "nortic-plugin")}
            value={address_locality}
            onChange={(address_locality) => setAttributes({ address_locality })}
          />
          <TextControl
            label={__("Telephone", "nortic-plugin")}
            value={telephone}
            onChange={(telephone) => setAttributes({ telephone })}
          />
          <TextControl
            label={__("Fax Number", "nortic-plugin")}
            value={fax_number}
            onChange={(fax_number) => setAttributes({ fax_number })}
          />
          <TextControl
            label={__("Email", "nortic-plugin")}
            value={email}
            onChange={(email) => setAttributes({ email })}
          />
        </div>
      </>
    );
  },
});
