import { registerBlockType } from "@wordpress/blocks";
import {
  useBlockProps,
  MediaUpload,
  MediaUploadCheck,
} from "@wordpress/block-editor";
import { Button } from "@wordpress/components";
import { __ } from "@wordpress/i18n";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes }) {
    const {
      imageUrl01,
      imageAlt01,
      imageUrl02,
      imageAlt02,
      imageUrl03,
      imageAlt03,
      imageUrl04,
      imageAlt04,
      imageUrl05,
      imageAlt05,
    } = attributes;
    const blockProps = useBlockProps();

    // handle image select
    const onImageSelect = (media) => {
      console.log(media);

      var img0, alt0;

      if (media[0]) {
        (img0 = media[0].url), (alt0 = media[0].alt);
      }

      var img1, alt1;

      if (media[1]) {
        (img1 = media[1].url), (alt1 = media[1].alt);
      }

      var img2, alt2;

      if (media[2]) {
        (img2 = media[2].url), (alt2 = media[2].alt);
      }

      var img3, alt3;

      if (media[3]) {
        (img3 = media[3].url), (alt3 = media[3].alt);
      }

      var img4, alt4;

      if (media[4]) {
        (img4 = media[4].url), (alt4 = media[4].alt);
      }

      setAttributes({
        imageUrl01: img0,
        imageAlt01: alt0,
        imageUrl02: img1,
        imageAlt02: alt1,
        imageUrl03: img2,
        imageAlt03: alt2,
        imageUrl04: img3,
        imageAlt04: alt3,
        imageUrl05: img4,
        imageAlt05: alt4,
      });
    };

    const ALLOWED_MEDIA_TYPES = ["image"];

    return (
      <div {...blockProps}>
        {imageUrl01 ? (
          <div className="nortic-plugin-image-gallery-container  grid-cols-3 gap-4">
            <div className="nortic-image-gallery-upload-wrapper">
              <img src={imageUrl01} alt={imageAlt01} />
            </div>
            {imageUrl02 && (
              <div className="nortic-image-gallery-upload-wrapper">
                <img src={imageUrl02} alt={imageAlt02} />
              </div>
            )}
            {imageUrl03 && (
              <div className="nortic-image-gallery-upload-wrapper">
                <img src={imageUrl03} alt={imageAlt03} />
              </div>
            )}
            {imageUrl04 && (
              <div className="nortic-image-gallery-upload-wrapper">
                <img src={imageUrl04} alt={imageAlt04} />
              </div>
            )}
            {imageUrl05 && (
              <div className="nortic-image-gallery-upload-wrapper">
                <img src={imageUrl05} alt={imageAlt05} />
              </div>
            )}
          </div>
        ) : (
          <MediaUploadCheck>
            <MediaUpload
              onSelect={onImageSelect}
              allowedTypes={ALLOWED_MEDIA_TYPES}
              multiple={true}
              render={({ open }) => <Button onClick={open}>Load images</Button>}
            />
          </MediaUploadCheck>
        )}
      </div>
    );
  },
  save({ attributes }) {
    const {
      imageUrl01,
      imageAlt01,
      imageUrl02,
      imageAlt02,
      imageUrl03,
      imageAlt03,
      imageUrl04,
      imageAlt04,
      imageUrl05,
      imageAlt05,
    } = attributes;
    const blockProps = useBlockProps.save();

    return (
      <div {...blockProps}>
        <div className="nortic-plugin-image-gallery-container  grid-cols-3 gap-4">
          <div className="nortic-image-gallery-upload-wrapper">
            <figure className="h-full">
              <img className="h-full object-cover" src={imageUrl01} />
              <figcaption>{imageAlt01}</figcaption>
            </figure>
          </div>
          {imageUrl02 ? (
            <div className="nortic-image-gallery-upload-wrapper">
              <figure className="h-full">
                <img className="h-full object-cover" src={imageUrl02} />
                <figcaption>{imageAlt02}</figcaption>
              </figure>
            </div>
          ) : null}

          {imageUrl03 ? (
            <div className="nortic-image-gallery-upload-wrapper">
              <figure className="h-full">
                <img className="h-full object-cover" src={imageUrl03} />
                <figcaption>{imageAlt03}</figcaption>
              </figure>
            </div>
          ) : null}

          {imageUrl04 ? (
            <div className="nortic-image-gallery-upload-wrapper">
              <figure className="h-full">
                <img className="h-full object-cover" src={imageUrl04} />
                <figcaption>{imageAlt04}</figcaption>
              </figure>
            </div>
          ) : null}

          {imageUrl05 ? (
            <div className="nortic-image-gallery-upload-wrapper">
              <figure className="h-full">
                <img className="h-full object-cover" src={imageUrl05} />
                <figcaption>{imageAlt05}</figcaption>
              </figure>
            </div>
          ) : null}
        </div>
      </div>
    );
  },
});
