import { registerBlockType } from '@wordpress/blocks';
import metadata from './block.json';
import Edit from './edit';
import save from './save';
import './scss/table-style.scss';

registerBlockType(metadata.name, {
    attributes: {
        ...metadata.attributes,
    },
    edit: Edit,
    save,
});
