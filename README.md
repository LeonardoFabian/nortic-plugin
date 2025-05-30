# Dependencias

```json {"id":"01J3HB6QTHAD2H6R9538V5SVPS"}
 "dependencies": {
    "@emotion/react": "^11.11.0",
    "@emotion/styled": "^11.11.0",
    "@glidejs/glide": "^3.6.0",
    "@mui/material": "^5.13.0",
    "@mui/system": "^5.13.2",
    "aos": "^2.3.4",
    "copyfiles": "^2.4.1",
    "flowbite": "^1.6.5",
    "openai": "^3.2.1"
  },

```

# Pasos ordenados para compilar sin errores

## Paso 1 - Frontend Blocks

* Eliminar la siguiente linea del archivo package.json si existe:

```json {"id":"01J3HB6QTJJ90FSFY3723XDCDM"}
{
    "type": "module"
}

```

* Eliminar el archivo webpack.config.js si existe
* Ejecutar el comando:

```node {"id":"01J3HB6QTJJ90FSFY374C29211"}
npm run build

```

## Paso 2 - Block-Editor blocks

* Añadir la siguiente linea al archivo package.json si no existe:

```json {"id":"01J3HB6QTJJ90FSFY37661AD1J"}
{
    "type": "module"
}

```

* Ir al archivo src/blocks/rating/frontend-rating.js y comentar las siguiente linea de codigo:

```javascript {"id":"01J3HB6QTJJ90FSFY376QF00TT"}
import LinearProgress, {linearProgressClasses} from "@mui/material/LinearProgress";
import Box from "@mui/material/Box";
import { styled } from "@mui/material/styles";

```

* Descomprimir el archivo webpack.config.js en la raiz del plugin

*** Contenido del archivo webpack.config.js:

```javascript {"id":"01J3HB6QTKDFT0H3JS449F04CP"}
import defaultConfig from "@wordpress/scripts/config/webpack.config.js";

export default {
  ...defaultConfig,
  entry: {
    ...defaultConfig.entry(),
    "admin/index": "./src/admin",
    "block-editor/index": "./src/block-editor",
    "block-editor/achievement/index": "./src/block-editor/achievement",
    "block-editor/award/index": "./src/block-editor/award",
    "block-editor/dependency/index": "./src/block-editor/dependency",
    "block-editor/document/index": "./src/block-editor/document",
    "block-editor/event/index": "./src/block-editor/event",
    "block-editor/faq/index": "./src/block-editor/faq",
    "block-editor/gallery/index": "./src/block-editor/gallery",
    "block-editor/newsletter/index": "./src/block-editor/newsletter",
    "block-editor/resolution/index": "./src/block-editor/resolution",
    "block-editor/service/index": "./src/block-editor/service",
    "block-editor/team/index": "./src/block-editor/team",
  },
};

```

* Ejecutar el comando:

```node {"id":"01J3HB6QTNYP74EJ8HHJ4WT561"}
npm run build

```

 <!-- Sellos NORTIC -->

                <div class="sellos-nortic">
                    <div class="stamp-container">
                        <div class="stamp-box">
                            <div class="stamp">
                                <a href="https://nortic.ogtic.gob.do/instituciones/MT" target="_blank" class="stamp stack-top" title="Norma sobre Publicación de Datos Abiertos del Gobierno Dominicano." rel="noopener">
    
                                    <iframe src="https://be.nortic.ogtic.gob.do/stampprocesses/stamp/147" height="100" width="100" frameborder="0" scrolling="no" style="width: 99%;"></iframe>
                                </a>
                            </div>
                        </div>
                        <div class="stamp-box">
                            <div class="stamp">
                                <a href="https://nortic.ogtic.gob.do/instituciones/MT" target="_blank" class="stamp stack-top" title="Norma para la Interoperabilidad entre los Organismos del Gobierno Dominicano." rel="noopener">
    
                                    <iframe src="https://be.nortic.ogtic.gob.do/stampprocesses/stamp/148" height="100" width="100" frameborder="0" scrolling="no" style="width: 99%;"></iframe>
    
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

## -Creating a translation template with the WP CLI

* Cut and paste in another directory the PLUGIN_NAME.pot file if exists
* Open Local by Flywheel
* Click on open the shell
* go to Wordpress root directory
* Move to plugin directory cd wp-content/plugins/PLUGIN_NAME
* Run the command wp i18n make-pot . languages/plugin-name.pot
* Start the site in Local by Flywheel
* Using Loco Translate to Sync the changes
* Translate the file
* Copy the .PO and .MO files to production
* NOTE: Translate in development and send the changes to production

```sh {"id":"01J3HB6QTRMMAASYC4FWZXGP27"}

```