import icons from './icons';
import './editor.scss';

import { withSelect } from "@wordpress/data";
import { __ } from "@wordpress/i18n";
import {
    RangeControl,
    PanelBody,
    ToggleControl,
    RadioControl,
    Spinner,
    Placeholder,
    SelectControl,
    __experimentalText as Text
} from "@wordpress/components";
import { InspectorControls, RichText, useBlockProps } from "@wordpress/block-editor";
import ServerSideRender from "@wordpress/server-side-render";

function CustomListArchiveEdit( props ) {

    const {
        lists,
        attributes,
        setAttributes,
        name,
    } = props;
    const {
        taxTermsSelected,
        sortBy,
        order,
		displayAs,
		columns,
		columnsTablet,
		columnsMobile,
		autoPlay,
		autoPlaySpeed,
		postsPerPage,
		showTitle,
		showDescription
    } = attributes;

    let options = [];
    if (lists) {
        options = lists.map(type => ({
            value: type.id,
            label: type.name
        }));

		if (!taxTermsSelected) {
			const selectAnItem = { value: null, label: 'Select a Category'};
			options.unshift(selectAnItem);
		}
    } else {
		options = [{
            value: 0,
            label: 'Loading...'
        }];
	}

    const listSelect = (
        <>
            <SelectControl
                label={__("Select Category", "carkeek-blocks")}
                onChange={ ( taxTermsSelected ) => setAttributes( { taxTermsSelected } ) }
                options={ options }
                value={taxTermsSelected}
            />
        </>
    );
    const inspectorControls = (
        <InspectorControls>
            <PanelBody title={__("List Settings", "carkeek-blocks")}>
                {listSelect}
                <SelectControl
                        label={__("Sort Links By", "carkeek-blocks")}
                        onChange={value =>
                            setAttributes({
                                sortBy: value
                            })
                        }
                        options={[
                            { label: __("Title (alpha)"), value: "title"},
                            { label: __("Menu Order"), value: "menu_order"},
                        ]}
                        value={sortBy}
                    />
                <RadioControl
                label={__("Order")}
                selected={order}
                options={[
                    { label: __("ASC"), value: "ASC"},
                    { label: __("DESC"), value: "DESC"},

                ]}
                onChange={value =>
                    setAttributes({
                        order: value
                    })
                }
            />

            </PanelBody>
            <PanelBody title={__("Layout", "carkeek-blocks")}>

                <RadioControl
                label={__("Display As", "carkeek-blocks")}
                selected={displayAs}
                options={[
                    { label: __("Grid"), value: "grid"},
                    { label: __("Carousel"), value: "carousel"},

                ]}
                onChange={value =>
                    setAttributes({
                        displayAs: value
                    })
                }
            />
			<RangeControl
						label={__("Limit Results", "carkeek-blocks")}
						help={__("Limit the number of results to show, select -1 to show all.", "carkeek-blocks")}
						value={postsPerPage}
						onChange={postsPerPage =>
							setAttributes({ postsPerPage })
						}
						min={-1}
						max={20}
					/>
                 <RangeControl
						label={__("Columns", "carkeek-blocks")}
						value={columns}
						onChange={value =>
							setAttributes({ columns: value })
						}
						min={1}
						max={6}
					/>
					<RangeControl
						label={__("Columns Mobile", "carkeek-blocks")}
						value={columnsMobile}
						onChange={value =>
							setAttributes({ columnsMobile: value })
						}
						min={1}
						max={6}
					/>
					<RangeControl
						label={__("Columns Tablet", "carkeek-blocks")}
						value={columnsTablet}
						onChange={value =>
							setAttributes({ columnsTablet: value })
						}
						min={1}
						max={6}
					/>
            </PanelBody>
			{displayAs === 'carousel' && (
				<PanelBody title={__("Carousel Settings", "carkeek-blocks")}>
					<ToggleControl
                            label="Auto Play Carousel"
                            checked={ autoPlay }
                            onChange={value =>
                                setAttributes({ autoPlay: value })
                            }
                        />
                        {autoPlay &&
                        <RangeControl
                            label={__("Time on each Slide (in ms)", "carkeek-blocks")}
                            value={autoPlaySpeed}
                            onChange={value =>
                                setAttributes({ autoPlaySpeed: value })
                            }
                            min={1000}
                            max={10000}
                        />
                        }
				</PanelBody>
			)}
			<PanelBody title={__("Item Layout", "carkeek-blocks")}>
				<ToggleControl
					label="Show Item Title"
					checked={ showTitle }
					onChange={value =>
						setAttributes({ showTitle: value })
					}
				/>
				<ToggleControl
					label="Show Item Description"
					checked={ showDescription }
					onChange={value =>
						setAttributes({ showDescription: value })
					}
				/>
			</PanelBody>
        </InspectorControls>
    );

    const blockProps = useBlockProps();

    if (!taxTermsSelected) {
        const noPostMessage = __("Select a Category from the Block Settings");

        return (
            <div { ...blockProps } >
                {inspectorControls}
                <Placeholder icon={icons.linkList} label={ __("YouTube Embed List")}>
                    <Spinner /> { noPostMessage }
                </Placeholder>
            </div>
        );
    } else {
		attributes.context = 'edit';
    return (
        <div { ...blockProps } >
            {inspectorControls}



            <ServerSideRender
                block={name}
                attributes={attributes}
			/>
            <div className="block-preview--notes">List preview. To edit the content visit Youtube Embeds in the admin dashboard.</div>
        </div>
    );
            }
}


export default withSelect((select, props) => {
    const listTax = 'embed_cat';
    const { attributes } = props;
    const { getEntityRecords } = select("core");
    const { taxTermsSelected, order, sortBy } = attributes;
    const lists = getEntityRecords('taxonomy', listTax, { per_page: -1, orderby: 'name', order: 'asc' } );


    return {
        lists: lists,
        taxTermsSelected:  Array.isArray(lists) && lists.length == 1 ? lists[0] : taxTermsSelected,
    };
})(CustomListArchiveEdit);
