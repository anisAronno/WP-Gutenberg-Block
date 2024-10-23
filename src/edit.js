import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, PanelRow, ToggleControl } from '@wordpress/components';
import { useEffect, useState } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

export default function Edit(props) {
    const { attributes, setAttributes } = props;
    const blockProps = useBlockProps();
    const [data, setData] = useState({ headers: [], rows: [] });

    const fetchTableData = () => {
        const requestData = new URLSearchParams({
            action: 'flexible_data_table_get_table_data',
            nonce: FlexibleDataTableBlockData.nonce,
        });

        fetch(FlexibleDataTableBlockData.ajax_url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: requestData.toString(),
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(result => {
            if (result.success && result.data) {
                const apiHeaders = result.data.data.headers;
                const apiRows = Object.values(result.data.data.rows).map(row => ({
                    'ID': row.id,
                    'First Name': row.fname,
                    'Last Name': row.lname,
                    'Email': row.email,
                    'Date': new Date(row.date * 1000).toLocaleDateString(),
                }));

                setData({
                    headers: apiHeaders,
                    rows: apiRows,
                });

                setAttributes({
                    tableData: { headers: apiHeaders, rows: apiRows }
                });
            }
        })
        .catch(error => console.error('Error fetching data:', error));
    };

    useEffect(() => {
        fetchTableData();
    }, []);

    const handleToggle = (column) => {
        const newVisibleColumns = { ...attributes.visibleColumns, [column]: !attributes.visibleColumns[column] };

        setAttributes({ visibleColumns: newVisibleColumns });
    };

    return (
        <div {...blockProps} className='flexible-data-table-block-table-container'>
            <InspectorControls>
                <PanelBody title={__('Column Visibility', 'custom')}>
                    {data.headers.map((header, index) => (
                        <PanelRow key={index}>
                            <ToggleControl
                                label={header}
                                checked={attributes.visibleColumns[header]}
                                onChange={() => handleToggle(header)}
                            />
                        </PanelRow>
                    ))}
                </PanelBody>
            </InspectorControls>
            <table>
                <thead>
                    <tr>
                        {data.headers.map((header, index) => (
                            attributes.visibleColumns[header] && <th key={index}>{header}</th>
                        ))}
                    </tr>
                </thead>
                <tbody>
                    {data.rows.map((row, rowIndex) => (
                        <tr key={rowIndex}>
                            {data.headers.map((header, colIndex) => (
                                attributes.visibleColumns[header] && <td key={colIndex}>{row[header]}</td>
                            ))}
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
}
