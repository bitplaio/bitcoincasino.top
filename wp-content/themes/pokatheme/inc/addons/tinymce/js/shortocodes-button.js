(function() {
    tinymce.PluginManager.add('poka_tc_button', function( editor, url ) {
        editor.addButton( 'poka_tc_button', {
            title: 'Shortcodes list',
            type: 'menubutton',
            icon: 'icon poka-own-icon',
            menu: [
                {
                    text: 'Reviews',
                    value: 'Various shortcodes',
                    onclick: function() {
                        return false;
                    },
                    menu: [
                        {
                            text: 'Reviews table',
                            value: '',
                            onclick: function() {
                                editor.windowManager.open( {
                                    title: 'Reviews table',
                                    body: [{
                                        type: 'textbox',
                                        name: 'num',
                                        label: 'Number of Reviews'
                                    },
                                    {
                                        type: 'textbox',
                                        name: 'cat',
                                        label: 'Category of Reviews'
                                    },
                                    {
                                        type: 'listbox',
                                        name: 'sort',
                                        label: 'Sort by',
                                        'values': [
                                            {text: 'Date', value: 'date'},
                                            {text: 'Rating', value: 'rating'},
                                            {text: 'Title', value: 'title'}
                                        ]
                                    },
                                    {
                                        type: 'textbox',
                                        name: 'reviews',
                                        label: 'Reviews IDs separated by comma'
                                    },
                                    {
                                        type: 'checkbox',
                                        name: 'logo_aff_link',
                                        label: 'Use affiliate link for the logo'
                                    },
                                    {
                                        type: 'checkbox',
                                        name: 'logo_color_box',
                                        label: 'Use logo background colors'
                                    },
                                    {
                                        type: 'checkbox',
                                        name: 'show_table_sorting',
                                        label: 'Show table sorting options'
                                    },
                                    {
                                        type: 'checkbox',
                                        name: 'big_table',
                                        label: 'Big style for full width'
                                    },
                                    {
                                        type: 'textbox',
                                        name: 'css_class',
                                        label: 'Custom CSS Class'
                                    }],
                                    onsubmit: function( e ) {
                                        var send_to_editor = '[table_list';
                                        if( e.data.num != "" ){
                                            send_to_editor += ' num="' + e.data.num + '"';
                                        }
                                        if( e.data.cat != "" ){
                                            send_to_editor += ' cat="' + e.data.cat + '"';
                                        }
                                        if( e.data.sort != "" ){
                                            send_to_editor += ' sort="' + e.data.sort + '"';
                                        }
                                        if( e.data.reviews != "" ){
                                            send_to_editor += ' reviews="' + e.data.reviews + '"';
                                        }
                                        if( e.data.big_table == true ){
                                            send_to_editor += ' big_table="true"';
                                        }
                                        if( e.data.logo_color_box == true ){
                                            send_to_editor += ' logo_color_box="true"';
                                        }
                                        if( e.data.show_table_sorting == true ){
                                            send_to_editor += ' show_table_sorting="true"';
                                        }
                                        if( e.data.logo_aff_link == true ){
                                            send_to_editor += ' logo_aff_link="true"';
                                        }
                                        if( e.data.css_class != "" ){
                                            send_to_editor += ' css_class="' + e.data.css_class + '"';
                                        }
                                        send_to_editor += ']';

                                        editor.insertContent(send_to_editor);
                                    }
                                });
                            }
                        },
                        {
                            text: 'Reviews table v2',
                            value: '',
                            onclick: function() {
                                editor.windowManager.open( {
                                    title: 'Reviews table v2',
                                    body: [{
                                        type: 'textbox',
                                        name: 'num',
                                        label: 'Number of Reviews'
                                    },
                                    {
                                        type: 'textbox',
                                        name: 'cat',
                                        label: 'Category of Reviews'
                                    },
                                    {
                                        type: 'listbox',
                                        name: 'sort',
                                        label: 'Sort by',
                                        'values': [
                                            {text: 'Date', value: 'date'},
                                            {text: 'Rating', value: 'rating'},
                                            {text: 'Title', value: 'title'}
                                        ]
                                    },
                                    {
                                        type: 'textbox',
                                        name: 'reviews',
                                        label: 'Reviews IDs separated by comma'
                                    },
                                    {
                                        type: 'checkbox',
                                        name: 'show_counter',
                                        label: 'Show counter'
                                    },
                                    {
                                        type: 'checkbox',
                                        name: 'show_freespins',
                                        label: 'Show freespins instead of bonus'
                                    },
                                    {
                                        type: 'checkbox',
                                        name: 'show_rating',
                                        label: 'Show rating'
                                    },
                                    {
                                        type: 'checkbox',
                                        name: 'logo_aff_link',
                                        label: 'Use affiliate link for the logo'
                                    },
                                    {
                                        type: 'checkbox',
                                        name: 'show_table_sorting',
                                        label: 'Show table sorting options'
                                    },
                                    {
                                        type: 'textbox',
                                        name: 'css_class',
                                        label: 'Custom CSS Class'
                                    }],
                                    onsubmit: function( e ) {
                                        var send_to_editor = '[table_list_v2';
                                        if( e.data.num != "" ){
                                            send_to_editor += ' num="' + e.data.num + '"';
                                        }
                                        if( e.data.cat != "" ){
                                            send_to_editor += ' cat="' + e.data.cat + '"';
                                        }
                                        if( e.data.sort != "" ){
                                            send_to_editor += ' sort="' + e.data.sort + '"';
                                        }
                                        if( e.data.reviews != "" ){
                                            send_to_editor += ' reviews="' + e.data.reviews + '"';
                                        }
                                        if( e.data.show_freespins == true ){
                                            send_to_editor += ' show_freespins="true"';
                                        }
                                        if( e.data.show_rating == true ){
                                            send_to_editor += ' show_rating="true"';
                                        }
                                        if( e.data.show_counter == true ){
                                            send_to_editor += ' show_counter="true"';
                                        }
                                        if( e.data.show_table_sorting == true ){
                                            send_to_editor += ' show_table_sorting="true"';
                                        }
                                        if( e.data.logo_aff_link == true ){
                                            send_to_editor += ' logo_aff_link="true"';
                                        }
                                        if( e.data.css_class != "" ){
                                            send_to_editor += ' css_class="' + e.data.css_class + '"';
                                        }
                                        send_to_editor += ']';

                                        editor.insertContent(send_to_editor);
                                    }
                                });
                            }
                        },
                        {
                            text: 'Reviews list',
                            value: '',
                            onclick: function() {
                                editor.windowManager.open( {
                                    title: 'Reviews list',
                                    body: [{
                                        type: 'textbox',
                                        name: 'num',
                                        label: 'Number of Reviews'
                                    },
                                    {
                                        type: 'textbox',
                                        name: 'cat',
                                        label: 'Category of Reviews'
                                    },
                                    {
                                        type: 'listbox',
                                        name: 'sort',
                                        label: 'Sort by',
                                        'values': [
                                            {text: 'Date', value: 'date'},
                                            {text: 'Rating', value: 'rating'},
                                            {text: 'Title', value: 'title'}
                                        ]
                                    },
                                    {
                                        type: 'textbox',
                                        name: 'reviews',
                                        label: 'Reviews IDs separated by comma'
                                    },
                                    {
                                        type: 'listbox',
                                        name: 'columns',
                                        label: 'Columns',
                                        'values': [
                                            {text: '2 columns', value: '2'},
                                            {text: '3 columns', value: '3'}
                                        ]
                                    }],
                                    onsubmit: function( e ) {
                                        var send_to_editor = '[affiliates_list';
                                        if( e.data.num != "" ){
                                            send_to_editor += ' num="' + e.data.num + '"';
                                        }
                                        if( e.data.cat != "" ){
                                            send_to_editor += ' cat="' + e.data.cat + '"';
                                        }
                                        if( e.data.sort != "" ){
                                            send_to_editor += ' sort="' + e.data.sort + '"';
                                        }
                                        if( e.data.reviews != "" ){
                                            send_to_editor += ' reviews="' + e.data.reviews + '"';
                                        }
                                        if( e.data.columns != "" ){
                                            send_to_editor += ' columns="' + e.data.columns + '"';
                                        }
                                        send_to_editor += ']';

                                        editor.insertContent(send_to_editor);
                                    }
                                });
                            }
                        },
                        {
                            text: 'Reviews carousel',
                            value: '',
                            onclick: function() {
                                editor.windowManager.open( {
                                    title: 'Reviews carousel',
                                    body: [{
                                        type: 'textbox',
                                        name: 'posts',
                                        label: 'Reviews list'
                                    },
                                    {
                                        type   : 'container',
                                        name   : 'container',
                                        label  : 'Info',
                                        html   : 'Separate posts with the character |<br/> For example: Review1|Review2'
                                    }],
                                    onsubmit: function( e ) {
                                        var send_to_editor = '[affiliates_carousel';
                                        if( e.data.posts != "" ){
                                            send_to_editor += ' posts="' + e.data.posts + '" ';
                                        }
                                        send_to_editor += ']';

                                        editor.insertContent(send_to_editor);
                                    }
                                });
                            }
                        },
                        {
                            text: 'Single Review',
                            value: '',
                            onclick: function() {
                                editor.windowManager.open( {
                                    title: 'Single Review',
                                    body: [{
                                        type: 'textbox',
                                        name: 'title',
                                        label: 'Review title'
                                    },
                                    {
                                        type: 'textbox',
                                        name: 'id',
                                        label: 'Review ID'
                                    },
                                    {
                                        type: 'listbox',
                                        name: 'size',
                                        label: 'Review size',
                                        'values': [
                                            {text: 'Big', value: 'big'},
                                            {text: 'Small', value: 'small'}
                                        ]
                                    }],
                                    onsubmit: function( e ) {
                                        var send_to_editor = '[single_affiliate';
                                        if( e.data.title != "" ){
                                            send_to_editor += ' title="' + e.data.title + '" ';
                                        }
                                        if( e.data.id != "" ){
                                            send_to_editor += ' id="' + e.data.id + '" ';
                                        }
                                        send_to_editor += 'size="' + e.data.size + '"]';

                                        editor.insertContent(send_to_editor);
                                    }
                                });
                            }
                        },
                        {
                            text: 'Single Review Free Spins',
                            value: '',
                            onclick: function() {
                                editor.windowManager.open( {
                                    title: 'Single Review Free Spins',
                                    body: [{
                                        type: 'textbox',
                                        name: 'title',
                                        label: 'Review title'
                                    },
                                    {
                                        type: 'textbox',
                                        name: 'id',
                                        label: 'Review ID'
                                    }],
                                    onsubmit: function( e ) {
                                        var send_to_editor = '[single_affiliate_freespins';
                                        if( e.data.title != "" ){
                                            send_to_editor += ' title="' + e.data.title + '" ';
                                        }
                                        if( e.data.id != "" ){
                                            send_to_editor += ' id="' + e.data.id + '" ';
                                        }
                                        send_to_editor += ']';

                                        editor.insertContent(send_to_editor);
                                    }
                                });
                            }
                        },
                        {
                            text: 'Single Review XL',
                            value: '',
                            onclick: function() {
                                editor.windowManager.open( {
                                    title: 'Single Review XL',
                                    body: [{
                                        type: 'textbox',
                                        name: 'title',
                                        label: 'Review title'
                                    },
                                    {
                                        type: 'textbox',
                                        name: 'id',
                                        label: 'Review ID'
                                    }],
                                    onsubmit: function( e ) {
                                        var send_to_editor = '[single_affiliate_xl';
                                        if( e.data.title != "" ){
                                            send_to_editor += ' title="' + e.data.title + '" ';
                                        }
                                        if( e.data.id != "" ){
                                            send_to_editor += ' id="' + e.data.id + '" ';
                                        }
                                        send_to_editor += ']';

                                        editor.insertContent(send_to_editor);
                                    }
                                });
                            }
                        },
                        {
                            text: 'Affiliate Button',
                            value: '',
                            onclick: function() {
                                editor.windowManager.open( {
                                    title: 'Affiliate Button',
                                    body: [{
                                        type: 'textbox',
                                        name: 'title',
                                        label: 'Button title'
                                    },
                                    {
                                        type: 'textbox',
                                        name: 'id',
                                        label: 'Affiliate link ID'
                                    }],
                                    onsubmit: function( e ) {
                                        var send_to_editor = '[affiliate_link';
                                        if( e.data.id != "" ){
                                            send_to_editor += ' id="' + e.data.id + '" ';
                                        }
                                        if( e.data.title != "" ){
                                            send_to_editor += ']' + e.data.title;
                                        } else {
                                            send_to_editor += ']Play Now!';
                                        }
                                        send_to_editor += '[/affiliate_link]';

                                        editor.insertContent(send_to_editor);
                                    }
                                });
                            }
                        },
                        {
                            text: 'Ajax Affiliates Search',
                            value: '',
                            onclick: function() {
                                editor.windowManager.open( {
                                    title: 'Ajax Affiliates Search',
                                    body: [{
                                        type: 'textbox',
                                        name: 'placeholder',
                                        label: 'Placeholder text'
                                    }],
                                    onsubmit: function( e ) {
                                        var send_to_editor = '[search_affiliates_ajax';
                                        if( e.data.placeholder != "" ){
                                            send_to_editor += ' placeholder="' + e.data.placeholder + '" ';
                                        }
                                        send_to_editor += ']';

                                        editor.insertContent(send_to_editor);
                                    }
                                });
                            }
                        }
                    ]
                },
                {
                    text: 'Single review shortcodes',
                    value: '',
                    onclick: function() {
                        return false;
                    },
                    menu: [
                        {
                            text: 'Ups and Downs',
                            value: '[upsdowns]',
                            onclick: function(e) {
                                e.stopPropagation();
                                editor.insertContent(this.value());
                            }
                        },
                        {
                            text: 'Screenshots carousel',
                            value: '',
                            onclick: function() {
                                editor.windowManager.open( {
                                    title: 'Screenshots carousel',
                                    body: [{
                                        type: 'textbox',
                                        name: 'title',
                                        label: 'Title'
                                    }],
                                    onsubmit: function( e ) {
                                        var send_to_editor = '[screenshots_carousel';
                                        if( e.data.title != "" ){
                                            send_to_editor += ' title="' + e.data.title + '"';
                                        }
                                        send_to_editor += ']';

                                        editor.insertContent(send_to_editor);
                                    }
                                });
                            }
                        },
                    ]
                },
                {
                    text: 'Various',
                    value: 'Variours shortcodes',
                    onclick: function() {
                        return false;
                    },
                    menu: [
                        {
                            text: 'Button',
                            value: '',
                            onclick: function() {
                                editor.windowManager.open( {
                                    title: 'Button',
                                    body: [{
                                        type: 'textbox',
                                        name: 'href',
                                        label: 'URL'
                                    },
                                    {
                                        type: 'textbox',
                                        name: 'title',
                                        label: 'Title'
                                    }],
                                    onsubmit: function( e ) {
                                        var send_to_editor = '[btn';
                                        if( e.data.name != "" ){
                                            send_to_editor += ' href="' + e.data.href + '"';
                                        }
                                        send_to_editor += ']';
                                        send_to_editor += e.data.title;
                                        send_to_editor += '[/btn]';

                                        editor.insertContent(send_to_editor);
                                    }
                                });
                            }
                        },
                        {
                            text: 'Box text',
                            value: '',
                            onclick: function() {
                                editor.windowManager.open( {
                                    title: 'Box text',
                                    body: [{
                                        type: 'textbox',
                                        name: 'icon',
                                        label: 'Icon'
                                    },
                                    {
                                        type: 'textbox',
                                        name: 'text',
                                        label: 'Text'
                                    }],
                                    onsubmit: function( e ) {
                                        var send_to_editor = '[box_text';
                                        if( e.data.icon != "" ){
                                            send_to_editor += ' icon="' + e.data.icon + '"';
                                        }
                                        send_to_editor += ']';
                                        send_to_editor += e.data.text;
                                        send_to_editor += '[/box_text]';

                                        editor.insertContent(send_to_editor);
                                    }
                                });
                            }
                        },
                        {
                            text: 'Slideshow',
                            value: '',
                            onclick: function() {
                                editor.windowManager.open( {
                                    title: 'Slideshow',
                                    body: [{
                                        type: 'textbox',
                                        name: 'title',
                                        label: 'Slidershow title'
                                    }],
                                    onsubmit: function( e ) {
                                        var send_to_editor = '[poka_slider';
                                        if( e.data.title != "" ){
                                            send_to_editor += ' title="' + e.data.title + '"';
                                        }
                                        send_to_editor += ']';

                                        editor.insertContent(send_to_editor);
                                    }
                                });
                            }
                        },
                        /*{
                            text: 'Games list',
                            value: '',
                            onclick: function() {
                                editor.windowManager.open( {
                                    title: 'Games list',
                                    body: [{
                                        type: 'textbox',
                                        name: 'num',
                                        label: 'Games number'
                                    },
                                    {
                                        type   : 'container',
                                        name   : 'container',
                                        label  : 'Info',
                                        html   : 'In order to display all games enter -1'
                                    },
                                    {
                                        type: 'textbox',
                                        name: 'cat',
                                        label: 'Games category'
                                    }
                                    ],
                                    onsubmit: function( e ) {
                                        var send_to_editor = '[games_list';
                                        if( e.data.num != "" ){
                                            send_to_editor += ' num="' + e.data.num + '"';
                                        }
                                        if( e.data.cat != "" ){
                                            send_to_editor += ' cat="' + e.data.cat + '"';
                                        }

                                        send_to_editor += ']';

                                        editor.insertContent(send_to_editor);
                                    }
                                });
                            }
                        },*/
                        {
                            text: 'News list',
                            value: '',
                            onclick: function() {
                                editor.windowManager.open( {
                                    title: 'News list',
                                    body: [{
                                        type: 'textbox',
                                        name: 'num',
                                        label: 'News number'
                                    },
                                    {
                                        type   : 'container',
                                        name   : 'container',
                                        label  : 'Info',
                                        html   : 'In order to display all news enter -1'
                                    },
                                    {
                                        type: 'textbox',
                                        name: 'cat',
                                        label: 'News category'
                                    },
                                    {
                                        type: 'listbox',
                                        name: 'descr_excerpt',
                                        label: 'Descriptions content',
                                        'values': [
                                            {text: 'Use truncated content', value: 'false'},
                                            {text: 'Use excerpt', value: 'true'}
                                        ]
                                    },
                                    {
                                        type: 'textbox',
                                        name: 'descr_length',
                                        label: 'Description length (default: 15 words)'
                                    },
                                    {
                                        type: 'textbox',
                                        name: 'read_more_text',
                                        label: 'Read more text button'
                                    }
                                    ],
                                    onsubmit: function( e ) {
                                        var send_to_editor = '[latest_news';
                                        if( e.data.num != "" ){
                                            send_to_editor += ' num="' + e.data.num + '"';
                                        }
                                        if( e.data.cat != "" ){
                                            send_to_editor += ' cat="' + e.data.cat + '"';
                                        }
                                        if( e.data.descr_excerpt != "" ){
                                            send_to_editor += ' descr_excerpt="' + e.data.descr_excerpt + '"';
                                        }
                                        if( e.data.descr_length != "" ){
                                            send_to_editor += ' descr_length="' + e.data.descr_length + '"';
                                        }
                                        if( e.data.read_more_text != "" ){
                                            send_to_editor += ' read_more_text="' + e.data.read_more_text + '"';
                                        }

                                        send_to_editor += ']';

                                        editor.insertContent(send_to_editor);
                                    }
                                });
                            }
                        },
                        {
                            text: 'News list sidebar',
                            value: '',
                            onclick: function() {
                                editor.windowManager.open( {
                                    title: 'News list sidebar',
                                    body: [{
                                        type: 'textbox',
                                        name: 'num',
                                        label: 'News number'
                                    },
                                    {
                                        type   : 'container',
                                        name   : 'container',
                                        label  : 'Info',
                                        html   : 'In order to display all news enter -1'
                                    },
                                    {
                                        type: 'textbox',
                                        name: 'cat',
                                        label: 'News category'
                                    }
                                    ],
                                    onsubmit: function( e ) {
                                        var send_to_editor = '[latest_news_sidebar';
                                        if( e.data.num != "" ){
                                            send_to_editor += ' num="' + e.data.num + '"';
                                        }
                                        if( e.data.cat != "" ){
                                            send_to_editor += ' cat="' + e.data.cat + '"';
                                        }

                                        send_to_editor += ']';

                                        editor.insertContent(send_to_editor);
                                    }
                                });
                            }
                        },
                        {
                            text: 'News boxes',
                            value: '',
                            onclick: function() {
                                editor.windowManager.open( {
                                    title: 'News boxes',
                                    body: [{
                                        type: 'textbox',
                                        name: 'cat',
                                        label: 'News category'
                                    }
                                    ],
                                    onsubmit: function( e ) {
                                        var send_to_editor = '[news_boxes';
                                        if( e.data.cat != "" ){
                                            send_to_editor += ' cat="' + e.data.cat + '"';
                                        }

                                        send_to_editor += ']';

                                        editor.insertContent(send_to_editor);
                                    }
                                });
                            }
                        },
                        {
                            text: 'Social links',
                            value: '[social_links]',
                            onclick: function(e) {
                                e.stopPropagation();
                                editor.insertContent(this.value());
                            }
                        },
                    ]
                },
                {
                    text: 'Columns',
                    value: '',
                    onclick: function() {
                        return false;
                    },
                    menu: [
                        {
                            text: 'Two columns',
                            value: '[two-cols-first] [/two-cols-first] [two-cols-last] [/two-cols-last]',
                            onclick: function(e) {
                                e.stopPropagation();
                                editor.insertContent(this.value());
                            }
                        },
                        {
                            text: 'Three Columns',
                            value: '[three-cols-first] [/three-cols-first] [three-cols-middle] [/three-cols-middle] [three-cols-last] [/three-cols-last]',
                            onclick: function(e) {
                                e.stopPropagation();
                                editor.insertContent(this.value());
                            }
                        },
                        {
                            text: 'Four Columns',
                            value: '[four-cols-first] [/four-cols-first] [four-cols-middle] [/four-cols-middle] [four-cols-middle] [/four-cols-middle] [four-cols-last] [/four-cols-last]',
                            onclick: function(e) {
                                e.stopPropagation();
                                editor.insertContent(this.value());
                            }
                        }
                    ]
                }
           ]
        });
    });
})();
