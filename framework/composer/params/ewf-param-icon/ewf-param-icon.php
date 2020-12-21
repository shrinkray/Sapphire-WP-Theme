<?php



	if ( function_exists('add_shortcode_param')){
	
		add_shortcode_param('ewf-icon', 'ewf_vc_param_icon_settings', get_template_directory_uri().'/framework/composer/params/ewf-param-icon/ewf-param-icon.js');
		
		function ewf_vc_param_icon_settings($settings, $value){
			$dependency = vc_generate_dependencies_attributes($settings);
			
			$param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
			$type = isset($settings['type']) ? $settings['type'] : '';
			$class = isset($settings['class']) ? $settings['class'] : '';
			
			
			
			/*###	Font Awesome	###*/
			
			$array_icons_fa = array( 
				"fa fa-adjust", "fa fa-anchor", "fa fa-archive", "fa fa-arrows", "fa fa-arrows-h", 
				"fa fa-arrows-v", "fa fa-asterisk", "fa fa-ban", "fa fa-bar-chart-o", "fa fa-barcode", 
				"fa fa-bars", "fa fa-beer", "fa fa-bell", "fa fa-bell-o", "fa fa-bolt", "fa fa-book", 
				"fa fa-bookmark", "fa fa-bookmark-o", "fa fa-briefcase", "fa fa-bug", "fa fa-building-o", 
				"fa fa-bullhorn", "fa fa-bullseye", "fa fa-calendar", "fa fa-calendar-o", "fa fa-camera", 
				"fa fa-camera-retro", "fa fa-caret-square-o-down", "fa fa-caret-square-o-left", 
				"fa fa-caret-square-o-right", "fa fa-caret-square-o-up", "fa fa-certificate", "fa fa-check", 
				"fa fa-check-circle", "fa fa-check-circle-o", "fa fa-check-square", "fa fa-check-square-o", 
				"fa fa-circle", "fa fa-circle-o", "fa fa-clock-o", "fa fa-cloud", "fa fa-cloud-download", 
				"fa fa-cloud-upload", "fa fa-code", "fa fa-code-fork", "fa fa-coffee", "fa fa-cog", 
				"fa fa-cogs", "fa fa-comment", "fa fa-comment-o", "fa fa-comments", "fa fa-comments-o", 
				"fa fa-compass", "fa fa-credit-card", "fa fa-crop", "fa fa-crosshairs", "fa fa-cutlery", 
				"fa fa-dashboard", "fa fa-desktop", "fa fa-dot-circle-o", "fa fa-download", "fa fa-edit", 
				"fa fa-ellipsis-h", "fa fa-ellipsis-v", "fa fa-envelope", "fa fa-envelope-o", "fa fa-eraser", 
				"fa fa-exchange", "fa fa-exclamation", "fa fa-exclamation-circle", "fa fa-exclamation-triangle", 
				"fa fa-external-link", "fa fa-external-link-square", "fa fa-eye", "fa fa-eye-slash", "fa fa-female", 
				"fa fa-fighter-jet", "fa fa-film", "fa fa-filter", "fa fa-fire", "fa fa-fire-extinguisher", "fa fa-flag", 
				"fa fa-flag-checkered", "fa fa-flag-o", "fa fa-flash", "fa fa-flask", "fa fa-folder", "fa fa-folder-o", 
				"fa fa-folder-open", "fa fa-folder-open-o", "fa fa-frown-o", "fa fa-gamepad", "fa fa-gavel", "fa fa-gear", 
				"fa fa-gears", "fa fa-gift", "fa fa-glass", "fa fa-globe", "fa fa-group", "fa fa-hdd-o", "fa fa-headphones", 
				"fa fa-heart", "fa fa-heart-o", "fa fa-home", "fa fa-inbox", "fa fa-info", "fa fa-info-circle", 
				"fa fa-key", "fa fa-keyboard-o", "fa fa-laptop", "fa fa-leaf", "fa fa-legal", "fa fa-lemon-o", 
				"fa fa-level-down", "fa fa-level-up", "fa fa-lightbulb-o", "fa fa-location-arrow", "fa fa-lock", 
				"fa fa-magic", "fa fa-magnet", "fa fa-mail-forward", "fa fa-mail-reply", "fa fa-mail-reply-all", 
				"fa fa-male", "fa fa-map-marker", "fa fa-meh-o", "fa fa-microphone", "fa fa-microphone-slash", 
				"fa fa-minus", "fa fa-minus-circle", "fa fa-minus-square", "fa fa-minus-square-o", "fa fa-mobile", 
				"fa fa-mobile-phone", "fa fa-money", "fa fa-moon-o", "fa fa-music", "fa fa-pencil", "fa fa-pencil-square", 
				"fa fa-pencil-square-o", "fa fa-phone", "fa fa-phone-square", "fa fa-picture-o", "fa fa-plane", 
				"fa fa-plus", "fa fa-plus-circle", "fa fa-plus-square", "fa fa-plus-square-o", "fa fa-power-off", 
				"fa fa-print", "fa fa-puzzle-piece", "fa fa-qrcode", "fa fa-question", "fa fa-question-circle", 
				"fa fa-quote-left", "fa fa-quote-right", "fa fa-random", "fa fa-refresh", "fa fa-reply", "fa fa-reply-all", 
				"fa fa-retweet", "fa fa-road", "fa fa-rocket", "fa fa-rss", "fa fa-rss-square", "fa fa-search", 
				"fa fa-search-minus", "fa fa-search-plus", "fa fa-share", "fa fa-share-square", "fa fa-share-square-o", 
				"fa fa-shield", "fa fa-shopping-cart", "fa fa-sign-in", "fa fa-sign-out", "fa fa-signal", "fa fa-sitemap", 
				"fa fa-smile-o", "fa fa-sort", "fa fa-sort-alpha-asc", "fa fa-sort-alpha-desc", "fa fa-sort-amount-asc", 
				"fa fa-sort-amount-desc", "fa fa-sort-asc", "fa fa-sort-desc", "fa fa-sort-down", "fa fa-sort-numeric-asc", 
				"fa fa-sort-numeric-desc", "fa fa-sort-up", "fa fa-spinner", "fa fa-square", "fa fa-square-o", "fa fa-star", 
				"fa fa-star-half", "fa fa-star-half-empty", "fa fa-star-half-full", "fa fa-star-half-o", "fa fa-star-o", 
				"fa fa-subscript", "fa fa-suitcase", "fa fa-sun-o", "fa fa-superscript", "fa fa-tablet", "fa fa-tachometer", 
				"fa fa-tag", "fa fa-tags", "fa fa-tasks", "fa fa-terminal", "fa fa-thumb-tack", "fa fa-thumbs-down", 
				"fa fa-thumbs-o-down", "fa fa-thumbs-o-up", "fa fa-thumbs-up", "fa fa-ticket", "fa fa-times", "fa fa-times-circle", 
				"fa fa-times-circle-o", "fa fa-tint", "fa fa-toggle-down", "fa fa-toggle-left", "fa fa-toggle-right", "fa fa-toggle-up", 
				"fa fa-trash-o", "fa fa-trophy", "fa fa-truck", "fa fa-umbrella", "fa fa-unlock", "fa fa-unlock-alt", "fa fa-unsorted", 
				"fa fa-upload", "fa fa-user", "fa fa-users", "fa fa-video-camera", "fa fa-volume-down", "fa fa-volume-off", 
				"fa fa-volume-up", "fa fa-warning", "fa fa-wheelchair", "fa fa-wrench");
				
				/*###	Icon Font Custom	###*/
				$array_icons_fontcustom = array( 
				"ifc-zoom_out","ifc-zoom_in","ifc-zip","ifc-yoga","ifc-yin_yang","ifc-yacht","ifc-xylophone","ifc-xray","ifc-xls",
				"ifc-xlarge_icons","ifc-workstation","ifc-workflow","ifc-workers","ifc-worker_with_roadblock","ifc-worker","ifc-word",
				"ifc-wma","ifc-winter_boots","ifc-winter","ifc-wink","ifc-wine_glass","ifc-wine","ifc-windows_client","ifc-wind_turbine",
				"ifc-wind_rose","ifc-wifi_logo","ifc-wifi_direct","ifc-wifi","ifc-whole_hand","ifc-wheelchair","ifc-wheelbarrow","ifc-wheel",
				"ifc-wheat","ifc-western","ifc-west_direction","ifc-weightlift","ifc-weght","ifc-week_view","ifc-wedding_rings",
				"ifc-wedding_photo","ifc-wedding_day","ifc-wedding_cake","ifc-webbing","ifc-web_shield","ifc-web_camera","ifc-waypoint_map",
				"ifc-waxing_gibbous","ifc-waxing_crescent","ifc-wav","ifc-watering_can","ifc-waterfall","ifc-water_hose","ifc-water_element",
				"ifc-water_bottle","ifc-water","ifc-watch","ifc-washing_machine","ifc-warning_shield","ifc-wardrobe","ifc-waning_gibbous",
				"ifc-waning_crescent","ifc-wallpaper_roll","ifc-wallet","ifc-walking_stick","ifc-walking_bridge","ifc-walking","ifc-walkie_talkie_radio",
				"ifc-walker","ifc-wacom_tablet","ifc-vpn","ifc-vomited","ifc-volume","ifc-volleyball","ifc-voip_gateway","ifc-voice_recognition_scan",
				"ifc-voice_presentation","ifc-vkontakte","ifc-visible","ifc-visa","ifc-virtual_mashine","ifc-virtual_machine","ifc-virgo","ifc-violin",
				"ifc-viking_ship","ifc-viking_helmet","ifc-video_camera","ifc-vegetarian_food","ifc-vegan_symbol","ifc-vegan_food","ifc-vector","ifc-variable",
				"ifc-van_dyke","ifc-vacuum_cleaner","ifc-user_shield","ifc-user_male4","ifc-user_male3","ifc-user_male2","ifc-user_male","ifc-user_female4",
				"ifc-user_female3","ifc-user_female2","ifc-user_female","ifc-USD","ifc-uppercase","ifc-upload2_filled","ifc-upload2","ifc-upload_filled",
				"ifc-upload","ifc-update","ifc-up4","ifc-up3","ifc-up2","ifc-up_right","ifc-up_left","ifc-up","ifc-unlock","ifc-university","ifc-unicast",
				"ifc-undo","ifc-underwear_woman","ifc-underwear_man","ifc-underline","ifc-umbrella_filled","ifc-umbrella","ifc-type","ifc-txt",
				"ifc-two_smartphones","ifc-two_hearts","ifc-two_fingers","ifc-twitter","ifc-tv_show","ifc-tv","ifc-turtle","ifc-tumbler",
				"ifc-tuba","ifc-ttf","ifc-trumpet","ifc-trousers","ifc-trophy","ifc-trombone","ifc-triller","ifc-trigonometry","ifc-triggering",
				"ifc-trigger_mode","ifc-tricycle","ifc-triangular_bandage","ifc-trekking","ifc-tree","ifc-treble_clef","ifc-treasury_map","ifc-trash2",
				"ifc-trash","ifc-transistor","ifc-trangia_stove","ifc-tram","ifc-trainers","ifc-train","ifc-trailer","ifc-tractor","ifc-track","ifc-towel",
				"ifc-torso","ifc-torii","ifc-torah","ifc-topic","ifc-toolbox_filled","ifc-toolbox","ifc-tongue_out","ifc-tones_filled","ifc-tones","ifc-tomato",
				"ifc-toilet_pan","ifc-toilet","ifc-today","ifc-tire","ifc-timezone-12","ifc-timezone-11","ifc-timezone-10","ifc-timezone-9","ifc-timezone-8",
				"ifc-timezone-7","ifc-timezone-6","ifc-timezone-5","ifc-timezone-4","ifc-timezone-3","ifc-timezone-2","ifc-timezone-1","ifc-timezone_utc",
				"ifc-timezone_12","ifc-timezone_11","ifc-timezone_10","ifc-timezone_9","ifc-timezone_8","ifc-timezone_7","ifc-timezone_6","ifc-timezone_5",
				"ifc-timezone_4","ifc-timezone_3","ifc-timezone_2","ifc-timezone_1","ifc-timezone","ifc-timer","ifc-time_trial_biking","ifc-tif","ifc-tie",
				"ifc-thumb_up","ifc-thumb_down","ifc-three_leafs_clover","ifc-three_fingers","ifc-thor_hammer","ifc-this_way_up","ifc-thimble","ifc-thermometer",
				"ifc-text_color","ifc-test_tube","ifc-tent","ifc-tennis","ifc-template","ifc-temperature_sensitive","ifc-temperature","ifc-teddybear","ifc-teapot",
				"ifc-tea","ifc-taxi","ifc-taurus","ifc-tar","ifc-tape_measure2","ifc-tape_measure","ifc-tape_drive","ifc-tap","ifc-talk","ifc-tails","ifc-taco",
				"ifc-table_radio","ifc-table","ifc-t_shirt","ifc-system_task","ifc-system_report","ifc-system_information","ifc-syringe","ifc-symbian","ifc-swivel",
				"ifc-switch_camera_filled","ifc-switch_camera","ifc-switch","ifc-swiss_army_knife","ifc-swipe_up","ifc-swipe_right","ifc-swipe_left","ifc-swipe_down",
				"ifc-swimming","ifc-suse","ifc-survival_bag","ifc-surprised","ifc-surgical_scissors","ifc-surface","ifc-sun","ifc-summer","ifc-sugar","ifc-student2"
				,"ifc-student_filled","ifc-student","ifc-stubble","ifc-stroller","ifc-strikethrough","ifc-street_view","ifc-strawberry","ifc-storm","ifc-stopwatch",
				"ifc-stop","ifc-stethoscope","ifc-stepper_motor","ifc-starfish","ifc-star_of_david","ifc-star_crescent","ifc-star","ifc-stapler","ifc-stanley_knife",
				"ifc-stack_of_photos_filled","ifc-stack_of_photos","ifc-stack","ifc-ssd","ifc-spruce","ifc-sproud","ifc-spring","ifc-spread","ifc-sports_mode",
				"ifc-spoon","ifc-spiderweb","ifc-spider","ifc-speedometer","ifc-speech_bubble_filled","ifc-speech_bubble","ifc-sparrow","ifc-spark_plug","ifc-spades",
				"ifc-soy","ifc-south_direction","ifc-sombrero","ifc-solar_panel","ifc-sofa","ifc-socks","ifc-snow_storm","ifc-snow","ifc-sniper_rifle","ifc-smoking",
				"ifc-smoke_explosion","ifc-smartphone_tablet","ifc-small_lens_filled","ifc-small_lens","ifc-small_icons","ifc-small_axe","ifc-slr_small_lens_filled",
				"ifc-slr_small_lens","ifc-slr_large_lens_filled","ifc-slr_large_lens","ifc-slr_camera2_filled","ifc-slr_camera2","ifc-slr_camera_filled",
				"ifc-slr_camera_body_filled","ifc-slr_camera_body","ifc-slr_camera","ifc-slr_back_side_filled","ifc-slr_back_side","ifc-sling_here","ifc-sleet",
				"ifc-sleeping_mat","ifc-sleeping_bag","ifc-sleeping","ifc-slave","ifc-skype","ifc-skirt","ifc-skip_to_start","ifc-skiing","ifc-side_dram",
				"ifc-side_burns","ifc-sickle","ifc-shunt","ifc-shuffle","ifc-shrimp","ifc-shovel2","ifc-shovel","ifc-shoulders","ifc-shorts","ifc-short_beard",
				"ifc-shopping_cart_loaded","ifc-shopping_cart_empty","ifc-shopping_basket","ifc-shop","ifc-shoes","ifc-shoe_woman","ifc-shoe_man","ifc-shirt",
				"ifc-shield","ifc-shellfish","ifc-sheep","ifc-shark","ifc-shared_filled","ifc-shared","ifc-settings3","ifc-settings2_filled","ifc-settings2",
				"ifc-settings_filled","ifc-settings","ifc-server","ifc-sent","ifc-sensor","ifc-sell","ifc-self_distruct_button","ifc-SEK","ifc-security_ssl",
				"ifc-security_checked","ifc-security_aes","ifc-search","ifc-seahorse","ifc-sea_waves","ifc-scythe","ifc-scrunchy","ifc-scrolling","ifc-screwdriver",
				"ifc-screw","ifc-scorpio","ifc-scooter","ifc-school","ifc-scatter_plot","ifc-scarf","ifc-scales_of_Balance_filled","ifc-scales_of_Balance",
				"ifc-saxophone","ifc-saw","ifc-satellites","ifc-satellite2_sending_signal","ifc-satellite2","ifc-satellite_in_orbit","ifc-santa","ifc-sallotape",
				"ifc-sale","ifc-sail_boat","ifc-sagrada_familia","ifc-sagittarius","ifc-safety_pin","ifc-safari","ifc-sad","ifc-running_rabbit","ifc-running",
				"ifc-run_command","ifc-rugby","ifc-rucksach","ifc-rss","ifc-rpg","ifc-router","ifc-rotation_cw","ifc-rotation_ccw","ifc-rotate_to_portrait",
				"ifc-rotate_to_landscape","ifc-rotate_camera_filled","ifc-rotate_camera","ifc-rope","ifc-rook","ifc-romper","ifc-romance","ifc-roller_brush",
				"ifc-rocket","ifc-robot","ifc-roadblock","ifc-road_worker","ifc-road","ifc-right3","ifc-right2","ifc-right_shoe","ifc-right_footprint",
				"ifc-right_click","ifc-right","ifc-rifle","ifc-rfid_tag","ifc-rfid_signal","ifc-rfid_sensor","ifc-rewind","ifc-retro_tv","ifc-restriction_shield",
				"ifc-restaurant","ifc-response","ifc-resize","ifc-resistor","ifc-replay","ifc-repeat","ifc-rename","ifc-remove_user","ifc-remove_image_filled",
				"ifc-remove_image","ifc-remote_working","ifc-reload","ifc-relay","ifc-regular_biking","ifc-register_editor","ifc-refresh_shield","ifc-redo",
				"ifc-red_hat","ifc-recycling","ifc-recycle_sign_filled","ifc-recycle_sign","ifc-rectangle","ifc-read_message","ifc-rattle","ifc-rar","ifc-rain",
				"ifc-railroad_car","ifc-radio_tower","ifc-radio_active","ifc-radio","ifc-radar_plot","ifc-rack","ifc-rabbit","ifc-quote","ifc-quill_with_ink",
				"ifc-quickdraw","ifc-question","ifc-queen_uk","ifc-queen","ifc-pyramids","ifc-puzzle_filled","ifc-puzzle","ifc-put_out","ifc-put_in_motion",
				"ifc-put_in","ifc-pumpkin","ifc-pulley","ifc-publisher","ifc-public","ifc-psyhology","ifc-psd","ifc-protect_from_magnetic_field","ifc-processor",
				"ifc-private2","ifc-private","ifc-print","ifc-price_tag_usd","ifc-price_tag_pound","ifc-price_tag_euro","ifc-price_tag","ifc-pretzel",
				"ifc-pressure","ifc-presentation_filled","ifc-presentation","ifc-prelum","ifc-pranava","ifc-power_point","ifc-powder","ifc-potentiometer",
				"ifc-positive_dynamic","ifc-portrait_mode","ifc-popular_topic","ifc-polyline","ifc-polygone","ifc-polygon","ifc-poll_topic","ifc-policeman",
				"ifc-poison","ifc-png","ifc-plus","ifc-plugin_filled","ifc-plugin","ifc-pliers","ifc-play","ifc-plasmid","ifc-plant_under_sun","ifc-plant_under_rain",
				"ifc-pizza","ifc-pitchfork","ifc-piston","ifc-pisces","ifc-pinterest","ifc-pingpong","ifc-pinch","ifc-pincette","ifc-pin_cusion","ifc-pin","ifc-pill",
				"ifc-pig","ifc-pie_chart","ifc-picture_filled","ifc-picture","ifc-pickup","ifc-piccolo","ifc-physics","ifc-photo","ifc-phone3","ifc-phone2","ifc-phone1",
				"ifc-perforator","ifc-pencil_sharpener","ifc-pen","ifc-pear","ifc-peanuts","ifc-pdf","ifc-pawn","ifc-pause","ifc-password2","ifc-password","ifc-passenger",
				"ifc-partly_cloudy_rain","ifc-partly_cloudy_night","ifc-partly_cloudy_day","ifc-park_bench","ifc-paper_clip","ifc-paper_clamp","ifc-paper_bag_with_seeds",
				"ifc-panorama","ifc-palm","ifc-paint_bucket","ifc-paint_basket","ifc-pain_brush","ifc-padding","ifc-pacifier","ifc-overhead_crane","ifc-outlook",
				"ifc-outline","ifc-outgoing_data","ifc-otf","ifc-osm","ifc-origami","ifc-opera","ifc-opened_folder_filled","ifc-opened_folder","ifc-open_in_browser",
				"ifc-online","ifc-one_note","ifc-one_finger","ifc-old_time_camera_filled","ifc-old_time_camera","ifc-ogg","ifc-office_lamp","ifc-octopus","ifc-oak_nut",
				"ifc-nurse","ifc-numerical_sorting_21","ifc-nuclear_power_plant","ifc-not_listen","ifc-north_direction","ifc-no_smoking","ifc-no_leather","ifc-no_eggs",
				"ifc-nmea","ifc-night_vision","ifc-night_portrait","ifc-night_landscape","ifc-news","ifc-new_moon",
				"ifc-neutral_decision","ifc-nerd","ifc-negative_dynamic","ifc-needle","ifc-neck","ifc-near_me","ifc-nas","ifc-nappy","ifc-nail","ifc-my_topic","ifc-mute",
				"ifc-mustache","ifc-musical","ifc-music_video","ifc-music_record","ifc-music_conductor","ifc-music","ifc-mushroom_cloud","ifc-mummy",
				"ifc-multiple_smartphones","ifc-multiple_inputs","ifc-multiple_devices","ifc-multiple_cameras","ifc-multicast","ifc-mpg","ifc-mp3","ifc-movie",
				"ifc-moved_topic","ifc-move_by_trolley","ifc-mov","ifc-mouse_trap_mouse","ifc-mouse_trap","ifc-mouse","ifc-mountain_biking","ifc-motorcycle",
				"ifc-motion_detector","ifc-mosque","ifc-mortar_and_pestle","ifc-mortar","ifc-moon","ifc-month_view","ifc-money_box","ifc-money_bag","ifc-money",
				"ifc-moderator","ifc-mobile_home","ifc-mixer","ifc-mittens","ifc-missile","ifc-minus","ifc-mind_map","ifc-milk","ifc-military_medal","ifc-military_backpack_radio",
				"ifc-microwave","ifc-microscope","ifc-micropore_tape","ifc-micro2","ifc-micro","ifc-message_filled","ifc-message","ifc-mess_tin","ifc-menu","ifc-menorah",
				"ifc-memory_module","ifc-megaphone2_filled","ifc-megaphone2","ifc-megaphone_filled","ifc-megaphone","ifc-meeting","ifc-medium_volume","ifc-medium_icons",
				"ifc-medium_battery","ifc-meditation_guru","ifc-medal","ifc-math","ifc-matches","ifc-mastercard","ifc-master","ifc-mashroom","ifc-marker_pen","ifc-marine_radio",
				"ifc-maple_leaf","ifc-map_marker","ifc-map_editing","ifc-map","ifc-mandriva","ifc-male","ifc-make_decision","ifc-magnet","ifc-magazine","ifc-mac_client",
				"ifc-lyre","ifc-luggage_trolley","ifc-lowercase","ifc-low_volume","ifc-low_battery","ifc-loudspeakers","ifc-lol","ifc-log_cabine","ifc-lock_portrait",
				"ifc-lock_landscape","ifc-lock_filled","ifc-lock","ifc-livingroom","ifc-little_snow","ifc-little_rain","ifc-literature","ifc-listen","ifc-list",
				"ifc-linux_client","ifc-linkedin","ifc-link_broken","ifc-link","ifc-line_width","ifc-line_chart","ifc-line","ifc-like","ifc-lighthouse",
				"ifc-lift_cart_here","ifc-libra","ifc-leo","ifc-length","ifc-leg","ifc-left3","ifc-left2","ifc-left_shoe","ifc-left_footprint","ifc-left_click",
				"ifc-left","ifc-led_diode","ifc-leaf","ifc-lcd","ifc-layers","ifc-law","ifc-last_quarter","ifc-laser_beam","ifc-large_lens_filled","ifc-large_lens",
				"ifc-large_icons","ifc-laptop","ifc-lantern","ifc-landscape","ifc-landing","ifc-lamp","ifc-ladder","ifc-koran","ifc-knight","ifc-knife","ifc-kmz",
				"ifc-kml","ifc-kitchen","ifc-kiss","ifc-king","ifc-keyboard","ifc-key_filled","ifc-key","ifc-kettle","ifc-keep_dry","ifc-jumper","ifc-jump_rope",
				"ifc-JPY","ifc-jpg","ifc-joystick_filled","ifc-joystick","ifc-joker","ifc-jingle_bell","ifc-jcb","ifc-java_duke_logo","ifc-java_coffee_cup_logo",
				"ifc-java_coffee_been_logo","ifc-jacket","ifc-italic","ifc-iron","ifc-iris_scan","ifc-iphone","ifc-ipad","ifc-ip_address","ifc-invisible","ifc-internet_explorer",
				"ifc-internal","ifc-integrated_webcam_filled","ifc-integrated_webcam","ifc-integrated_circuit","ifc-instagram","ifc-infrared_beam_sensor",
				"ifc-infrared_beam_sending","ifc-infrared","ifc-informatics","ifc-info_filled","ifc-info","ifc-increase_font","ifc-incoming_data","ifc-incendiary_grenade",
				"ifc-inbox","ifc-in_love","ifc-import","ifc-idea_filled","ifc-idea","ifc-icq","ifc-hydroelectric","ifc-humidity","ifc-humburger","ifc-human_footprints",
				"ifc-hub","ifc-html","ifc-hot_dog","ifc-hot_chocolate","ifc-horseshoe","ifc-horror2","ifc-horror","ifc-hops","ifc-honey","ifc-home_filled","ifc-home",
				"ifc-HKD","ifc-history","ifc-high_volume","ifc-high_battery","ifc-hex_burner","ifc-herald_trumpet","ifc-help2_filled","ifc-help2","ifc-help_filled",
				"ifc-help","ifc-helmet","ifc-helicopter","ifc-heating_room","ifc-heat_map","ifc-hearts","ifc-heart_monitor","ifc-hearing_aid","ifc-headstone","ifc-headset",
				"ifc-headphones","ifc-hdd","ifc-hazelnut","ifc-hatchet","ifc-hat","ifc-harness","ifc-happy","ifc-hanger","ifc-handle_with_care","ifc-hand_planting",
				"ifc-hand_palm_scan","ifc-hand_biceps","ifc-hand","ifc-hammer","ifc-hair_dryer","ifc-hair_clip","ifc-hair_brush","ifc-hair_band","ifc-hail","ifc-guru",
				"ifc-guitar","ifc-group","ifc-grenade","ifc-greentech","ifc-great_wall","ifc-grass","ifc-grapes","ifc-gpx","ifc-gps_receiving","ifc-gps_disconnected",
				"ifc-gorilla","ifc-google_plus","ifc-good_decision","ifc-goatee","ifc-glue","ifc-globe_filled","ifc-gis","ifc-gingerbread_men","ifc-gift","ifc-gif","ifc-ghost",
				"ifc-german_hat","ifc-geothermal","ifc-geometry","ifc-geography","ifc-geocaching","ifc-geo_fence","ifc-generic_text","ifc-generic_sorting2","ifc-generic_sorting",
				"ifc-genealogy","ifc-genderqueer","ifc-gender","ifc-gemini","ifc-geisha","ifc-GBP","ifc-gatling_gun","ifc-gas2","ifc-gas_mask","ifc-gas","ifc-garden_shears",
				"ifc-garden_gloves","ifc-garage","ifc-gantt_chart","ifc-gallery_filled","ifc-gallery","ifc-gaiters","ifc-fully_charged_battery","ifc-full_moon","ifc-frisbee",
				"ifc-fridge","ifc-french_horn","ifc-french_fries","ifc-fragile","ifc-foursquare","ifc-four_fingers","ifc-forward2","ifc-forward","ifc-fortune_teller","ifc-fork_truck",
				"ifc-fork","ifc-forest","ifc-football2","ifc-football","ifc-food","ifc-folder_filled","ifc-folder","ifc-fog_night","ifc-fog_day","ifc-flv","ifc-flower","ifc-flow_chart",
				"ifc-floating_guru","ifc-flip_vertical","ifc-flip_horizontal","ifc-flip_flops","ifc-flash_light_filled","ifc-flash_light","ifc-flash_bang","ifc-flag2","ifc-flag_filled",
				"ifc-flag","ifc-fish","ifc-first_quarter","ifc-firing_gun","ifc-firewall","ifc-fireman","ifc-firefox","ifc-fire_extinguisher","ifc-fire_element","ifc-finish_flag",
				"ifc-fingerprint_scan","ifc-find_user","ifc-filter","ifc-film_reel_filled","ifc-film_reel","ifc-filled_box","ifc-ferry","ifc-female","ifc-fb2","ifc-fast_forward",
				"ifc-farmer","ifc-fantasy","ifc-fan","ifc-false_teeth","ifc-fairytale","ifc-facebook","ifc-face_recognition_scan","ifc-external_link","ifc-external","ifc-export",
				"ifc-explosion","ifc-expensive","ifc-expand","ifc-exit","ifc-exe","ifc-excel","ifc-EUR","ifc-error","ifc-erotic","ifc-eraser","ifc-epub","ifc-eps","ifc-enter",
				"ifc-engineering","ifc-engine","ifc-engagement_ring","ifc-energy_absorber","ifc-end","ifc-empty_box","ifc-email","ifc-ellipse","ifc-electronics","ifc-electro_devices",
				"ifc-electricity","ifc-electric_teapot","ifc-eggs","ifc-edit_user","ifc-edit_image_filled","ifc-edit_image","ifc-edit","ifc-east_direction","ifc-earth_element",
				"ifc-dumbbell","ifc-duck","ifc-driver","ifc-drill","ifc-dribbble","ifc-drama","ifc-drafting_compass","ifc-downpour","ifc-download2_filled","ifc-download2",
				"ifc-download_filled","ifc-download","ifc-down4","ifc-down2","ifc-down_right","ifc-down_left","ifc-down","ifc-double_tap","ifc-donut_chart","ifc-domain","ifc-dolphin",
				"ifc-dog_footprint","ifc-dog","ifc-documentary","ifc-document_filled","ifc-document","ifc-doctor_suitecase","ifc-doctor","ifc-doc","ifc-do_not_tilt","ifc-do_not_stack",
				"ifc-do_not_expose_to_sunlight","ifc-do_not_drop","ifc-dna_helix","ifc-dmg","ifc-dll","ifc-dj","ifc-display","ifc-disapprove","ifc-directions","ifc-diningroom","ifc-dinghy",
				"ifc-dice","ifc-diamonds","ifc-dharmacakra","ifc-devil","ifc-device_manger","ifc-detective","ifc-details","ifc-design","ifc-deployment","ifc-delivery","ifc-delete_sign",
				"ifc-delete_shield","ifc-delete_message","ifc-degrees","ifc-define_location","ifc-decrease_font","ifc-decision","ifc-debian","ifc-deadly_spray","ifc-day_view","ifc-date_to",
				"ifc-date_from","ifc-date","ifc-database_protection","ifc-database_encryption","ifc-database_backup","ifc-database","ifc-data_in_both_directions","ifc-cymbals","ifc-cut_filled",
				"ifc-cut","ifc-currency","ifc-csv","ifc-css","ifc-crystal_oscillator","ifc-crystal_ball","ifc-crying_baby","ifc-cry","ifc-crutch","ifc-cruise_ship","ifc-cross","ifc-crop",
				"ifc-criminal","ifc-crib","ifc-creek","ifc-credit_card","ifc-crazy","ifc-crab","ifc-cow","ifc-cottage","ifc-cornet","ifc-corkscrew","ifc-coral","ifc-copy_link","ifc-copy",
				"ifc-cool","ifc-cooking_pot","ifc-cooker_hood","ifc-cooker","ifc-cook","ifc-control_panel","ifc-content","ifc-contacts","ifc-contact_card","ifc-construction_worker","ifc-console",
				"ifc-connected_no_data","ifc-confused","ifc-conference","ifc-computer","ifc-compost_heap","ifc-compass2","ifc-compas","ifc-commode","ifc-command_line","ifc-comedy2","ifc-comedy",
				"ifc-combo_chart","ifc-comb","ifc-color_dropper","ifc-collect","ifc-collapse","ifc-collaboration","ifc-coffeemaker","ifc-coffee_to_go","ifc-coffee","ifc-code","ifc-coctail",
				"ifc-coat","ifc-clubs","ifc-clown_fish","ifc-clover","ifc-clouds","ifc-cloud_storage","ifc-closed_topic","ifc-close_up_mode","ifc-close","ifc-clock","ifc-cloakroom",
				"ifc-clipperboard","ifc-clinic","ifc-climbing_shoes","ifc-climbing_helmet","ifc-climbing","ifc-clear_shopping_cart","ifc-clarnet","ifc-citrus","ifc-circuit","ifc-chrome",
				"ifc-christmas_tree","ifc-christmas_star","ifc-christmas_sock","ifc-christmas_snowman","ifc-christmas_snowflake","ifc-christmas_sleigh","ifc-christmas_penguin",
				"ifc-christmas_mitten","ifc-christmas_ice_skate","ifc-christmas_hat","ifc-christmas_gift","ifc-christmas_firework","ifc-christmas_deer","ifc-christmas_candy_cane",
				"ifc-christmas_candy","ifc-christmas_candle","ifc-christmas_ball","ifc-chisel_tip_marker","ifc-chip","ifc-chili_pepper","ifc-child_new_post","ifc-chicken",
				"ifc-chichen_itza","ifc-chiansaw","ifc-CHF","ifc-chest","ifc-cheese","ifc-checkmark","ifc-checked_user","ifc-cheap","ifc-charge_battery","ifc-change_user",
				"ifc-championship_belt","ifc-champagne","ifc-chalk_bag","ifc-centre_of_gravity","ifc-center_direction","ifc-cat_footprint","ifc-cat","ifc-cash_receiving",
				"ifc-cars","ifc-carrot","ifc-cargo_ship","ifc-cards","ifc-card_inserting","ifc-card_in_use","ifc-carabiner","ifc-car_battery","ifc-capricorn","ifc-capacitor",
				"ifc-cannon","ifc-candy","ifc-cancer","ifc-cancel","ifc-camping_tent","ifc-camping_gas_burner","ifc-campfire","ifc-camo_cream","ifc-camera_identification",
				"ifc-camera_addon_identification","ifc-camera_addon","ifc-camcoder_pro_filled","ifc-camcoder_pro","ifc-camcoder_filled","ifc-camcoder","ifc-calendar","ifc-CAD",
				"ifc-cable_release","ifc-button","ifc-business","ifc-bus","ifc-bungalow","ifc-bunch_ingredients","ifc-bull","ifc-bugle","ifc-bug2","ifc-bug","ifc-brush",
				"ifc-broom","ifc-broadcasting","ifc-briefcase_filled","ifc-briefcase","ifc-brick","ifc-bread","ifc-brandenburg_gate","ifc-brain_filled",
				"ifc-brain","ifc-bra","ifc-box2","ifc-box","ifc-bowler_hat","ifc-border_color","ifc-boots","ifc-boombox","ifc-bookmark","ifc-bomb","ifc-bold","ifc-bobbin",
				"ifc-blur","ifc-blunderbuss","ifc-bluetooth2","ifc-bluetooth","ifc-birthday_cake","ifc-birthday","ifc-biotech","ifc-biomass","ifc-biohazard","ifc-bicycle",
				"ifc-bib","ifc-bell_service","ifc-belayer","ifc-beer_glass","ifc-beer_bottle","ifc-beer","ifc-bed","ifc-bebo","ifc-bear_footprint","ifc-bathroom","ifc-bath",
				"ifc-bat","ifc-bass_dram","ifc-basketball","ifc-baseball_cap","ifc-barley","ifc-barcode_scanner","ifc-barbers_scissors","ifc-barbers_pole","ifc-barbers_chair",
				"ifc-barbell","ifc-bar_chart","ifc-banknotes","ifc-bandage","ifc-ball_point_pen","ifc-bad_decision","ifc-background_color","ifc-back2","ifc-back","ifc-babyroom",
				"ifc-baby_feet","ifc-baby_bottle","ifc-baby","ifc-avi","ifc-average","ifc-autumn","ifc-automotive","ifc-audio_wave2","ifc-audio_wave","ifc-AUD","ifc-ascender","ifc-asc",
				"ifc-armchair","ifc-aries","ifc-area_chart","ifc-archive_filled","ifc-archive","ifc-aquarius","ifc-application_shield","ifc-apartment","ifc-anubis","ifc-antiseptic_cream",
				"ifc-ankh","ifc-angry","ifc-angel","ifc-android_os","ifc-ancore","ifc-anchor","ifc-ammo_tin","ifc-amex","ifc-ambulance","ifc-alphabetical_sorting_za",
				"ifc-alphabetical_sorting_az","ifc-align_right","ifc-align_left","ifc-align_justify","ifc-align_center","ifc-alarm_clock","ifc-airplane_take_off","ifc-airplane_mode_on",
				"ifc-airplane_mode_off","ifc-airplane","ifc-air_element","ifc-ai","ifc-age","ifc-adventures","ifc-adobe_photoshop","ifc-adobe_indesign","ifc-adobe_illustrator",
				"ifc-adobe_flash","ifc-adobe_fireworks","ifc-adobe_dreamweaver","ifc-adobe_bridge","ifc-administrative_tools","ifc-add_user","ifc-add_image_filled","ifc-add_image",
				"ifc-add_database","ifc-action","ifc-zip2","ifc-f_tap","ifc-f_swipe_up","ifc-f_swipe_right","ifc-f_swipe_left","ifc-f_swipe_down","ifc-f_double_tap"				
				);
			
	$output .= '<div class="ewf-icon-wrapper">
					
					<div class="ewf-icon-ct-wrapper">
					<div class="ewf-icon-ct-position">
					<div class="pos ewf-icon-ct-top"></div>
					<div class="pos ewf-icon-ct-top-left"></div>
					<div class="pos ewf-icon-ct-top-rigth"></div>
					<div class="pos ewf-icon-ct-left"></div>
							<div class="pos ewf-icon-ct-center"></div>
							<div class="pos ewf-icon-ct-right"></div>
							<div class="pos ewf-icon-ct-bottom"></div>
							<div class="pos ewf-icon-ct-bottom-left"></div>
							<div class="pos ewf-icon-ct-bottom-right"></div>
							
							<div class="border-square"></div>
							</div>
							
						<div class="ewf-icon-ct-selection">
						<i class="'.$value.'" ></i>
						</div>
						
						<a class="button button-primary button-large ewf-icon-ct-change" type="button" href="#">Change Icon</a>
						<a class="button button-primary button-large ewf-icon-ct-cancel" type="button" href="#">Cancel</a>
						</div>
					
					<ul class="ewf-icon-filters">';
						
						
						// $output .= '<li class="ewf-icon-set">Font Awesome</li>';
						// foreach( $array_icons_fa as $key => $icon_class){
							// $output .= '<li><i class="'.$icon_class.'" ></i></li>';
						// }
						
						// $output .= '<li class="ewf-icon-set mt">Icon Font Custom</li>';
						foreach( $array_icons_fontcustom as $key => $icon_class){
							$output .= '<li><i class="'.$icon_class.'" ></i></li>';
						}						

		$output .= '</ul>
				</div>';
				$output .= '<input type="hidden" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="'.$value.'" />';
			
			return $output;
		}
	}
?>