import { useBlockProps } from '@wordpress/block-editor';

export default function save(props) {
    const { attributes } = props;
    const blockProps = useBlockProps.save();

    return (
        <div {...blockProps} className='flexible-data-table-block-table-container'>
            <table>
                <thead>
                    <tr>
                        {attributes.tableData.headers.map((header, index) => (
                            attributes.visibleColumns[header] && <th key={index}>{header}</th>
                        ))}
                    </tr>
                </thead>
                <tbody>
                    {attributes.tableData.rows.map((row, rowIndex) => (
                        <tr key={rowIndex}>
                            {attributes.tableData.headers.map((header, colIndex) => (
                                attributes.visibleColumns[header] && <td key={colIndex}>{row[header]}</td>
                            ))}
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
}
