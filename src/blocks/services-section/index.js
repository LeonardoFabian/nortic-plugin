import block from './block.json';
import icons from '../../icons.js';
import './main.css';
import { registerBlockType } from '@wordpress/blocks';
import { InnerBlocks, useBlockProps, MediaPlaceholder, BlockControls, MediaReplaceFlow, RichText } from '@wordpress/block-editor';
import { isBlobURL, revokeBlobURL } from '@wordpress/blob';
import { useSelect } from '@wordpress/data';
import { useState } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

registerBlockType(block.name, {
    icon: icons.domo,
    edit({ attributes, setAttributes }) {

        const { heading, subheading } = attributes;

        const blockProps = useBlockProps();

        return (
            <div {...blockProps}>
                <div className='services-section-header'>
                    <RichText 
                        tagName='h2'
                        className='services-section-heading'
                        placeholder={__("Click add a heading", "nortic-plugin")}
                        value={heading}
                        onChange={(heading) => setAttributes({ heading })}
                        allowedFormats={[
                            "core/bold",
                            "core/link",
                            "core/text-color",
                        ]}
                    />
                    <RichText 
                        tagName='h4'
                        className='services-section-subheading'
                        placeholder={__("Click add a subheading", "nortic-plugin")}
                        value={subheading}
                        onChange={(subheading) => setAttributes({ subheading })}
                        allowedFormats={[
                            "core/italic",
                            "core/text-color",
                        ]}
                    />
                </div>
                <InnerBlocks />
            </div>
        );

    },
    save({ attributes }) {

        const { heading, subheading } = attributes;

        const blockProps = useBlockProps.save();

        return (
            <div {...blockProps}>
                {
                    heading !== "" || subheading !== "" ? (
                        <div className='services-section-header'>
                            <RichText.Content 
                                tagName='h2'
                                className='services-section-heading'
                                value={heading}
                            />
                            <RichText.Content 
                                tagName='h4'
                                className='services-section-subheading'
                                value={subheading}
                            />
                        </div>
                    ) : null 
                }
                <div className='services-section-content-wrapper' data-glide-el="track">
                    <ul class="glide__slides">
                        <InnerBlocks.Content />
                    </ul>                    
                </div>

                <div class="glide__arrows" data-glide-el="controls">
                    <button class="glide__arrow glide__arrow--left" data-glide-dir="<">prev</button>
                    <button class="glide__arrow glide__arrow--right" data-glide-dir=">">next</button>
                </div>
            </div>
        );
    }
});