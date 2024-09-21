import block from "./block.json"
import icons from "../../icons.js";
import "./main.css";
import {registerBlockType} from "@wordpress/blocks";
import {useBlockProps} from "@wordpress/block-editor";
import { __ } from "@wordpress/i18n";
import {useSelect} from "@wordpress/data";

registerBlockType(block.name, {
    icon: icons.domo,
    edit({attributes, setAttributes, context}) {

        const {taxonomy, terms} = attributes;

        console.log("Entity Context: ", context);
        
        // get terms by taxonomy
        const serviceClassificationTerms = useSelect((select) => {
            return select("core").getEntityRecords("taxonomy", taxonomy, {
                per_page: -1,
            })
        }, []);
        const termsArray = {};

        serviceClassificationTerms?.forEach((term) => {
            termsArray[term.name] = term;
        });

        const termsIDs = terms.map((term) => term.id);
        console.log("Terms IDs: ", serviceClassificationTerms);

        return (
            <div>
                <p className="my-3">Este block se renderiza con PHP, y mostrará un arcordeon de servicios, dependiendo de la taxonomia donde te encuentres, listadas a continuación:</p>
                <div className="my-3">
                    <ul className="max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
                        {serviceClassificationTerms?.map((term, i) => (
                            <li 
                                key={term.id}
                                className="uppercase py-3 border-t-2 border-b-2 border-slate-300"
                            >
                                {term.name}
                            </li>
                        ))}
                    </ul>
                </div>
            </div>
        )
    }
})