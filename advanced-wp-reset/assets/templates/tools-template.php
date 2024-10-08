<!-- Video alert -->

<?php 
// We don't show the video if the user does not want to
if ( !in_array ('tools', $hidden_videos) ) { ?>

<div class="awpr-video-alert border border-[#00AD00] bg-[#00AD00]/10 px-5 py-4 mb-4 rounded flex items-center justify-between gap-3">

    <div class="flex items-center gap-3">

        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 35 36" class="w-8 h-8">

            <circle cx="17.308" cy="18.156" r="17.188" fill="#00AD00"/>

            <path fill="#E3F6E3" d="m13.254 11.316 10.292 6.513a.513.513 0 0 1 .178.194.566.566 0 0 1 0 .529.513.513 0 0 1-.178.194L13.254 25.26a.46.46 0 0 1-.492 0 .512.512 0 0 1-.18-.195.565.565 0 0 1-.065-.267V11.775a.57.57 0 0 1 .066-.267.513.513 0 0 1 .18-.194.46.46 0 0 1 .491.002Z"/>

        </svg>

        <p class="text-[#00AD00]">

            Perform partial Resets and targeted cleanups, 

            <a class="video-popup-btn text-[#00AD00] hover:text-[#00AD00] focus:text-[#00AD00] active:text-[#00AD00] font-bold underline" data-autoplay="true" data-vbtype="video" href="https://youtu.be/poa1iXGdqGg" data-maxwidth="800px">

                watch demo

            </a>

        </p>

    </div>

    <button type="button" class="awpr-video-alert-close-btn text-[#06283D] opacity-50 hover:opacity-100 transition awr-hide-video" data-video="tools" >

        <span class="icon-close"></span>

    </button>

</div>

<?php

}

$ItemsFetcherService = 'awr\services\ToolsResetService';

if ( AWR_IS_PRO_VERSION )

    $ItemsFetcherService = 'awr\services_pro\ToolsResetService';

// Prepare the list of items to reset with their explanations

$items_array = $ItemsFetcherService::get_instance()->get_tasks();

foreach ($items_array as $item_type => $item_info) { 

    $is_bloc_in_pro_only = array_key_exists('in-pro-only', $item_info) && $item_info['in-pro-only'] == true;

    $table_title = $item_info['table_title'];

    $table_title_coded = preg_replace('/\s+/', '_', strtolower($table_title));

    $accordion_id = 'awr-acc-tls-' . $table_title_coded;

    ?>

    <!-- Accordion -->

    <div class="awpr-single-accordion <?php echo in_array($accordion_id, $hidden_blocs) ? '' : 'awpr_accordion_default_opener'; ?>">

        <div class="awpr-accordion-title-wrapper awpr_accordion_handler" id="<?php echo $accordion_id; ?>">

            <div class="awpr-accordion-title">

                <div class="awpr-heading-icon">

                    <span class="<?php echo $item_info['icon_class']; ?>"></span>

                    <?php //echo $item_info['SVG']; ?>

                </div>

                <?php echo $table_title;

                if ( $is_bloc_in_pro_only ) {

                    echo $premium_bloc; 

                } ?>

            </div>

            <div class="awpr-accordion-icon awpr-acc-arrow">

                <span class="icon-arrow-down text-base"></span>

            </div>

        </div>

        <!-- Accordion content -->

        <div class="awpr-accordion-content-wrapper awpr_accordion_content_panel">

            <div class="awpr-accordion-content">

                <?php if ($is_bloc_in_pro_only) { echo $premium_frame_div_start; } ?>

                    <!-- Rows -->

                    <?php 

                    $tasks_count = count($item_info['table_tasks']);

                    $i = 1;

                    $border_bottom = "border-b";

                    foreach ($item_info['table_tasks'] as $row_task) { 

                        $is_task_in_pro_only = array_key_exists('in-pro-only', $row_task) && $row_task['in-pro-only'] == true;

                        if ( $i++ == $tasks_count ) {

                            $border_bottom = "";

                        }

                        ?>

                    <div class="grid gap-2 grid-cols-12 items-start justify-start py-4 border-[#CBBDD4] <?php echo $border_bottom; ?> <?php if ( array_key_exists('available', $row_task) && $row_task['available'] == false) { echo 'opacity-50'; }?>">

                        <!-- Left side -->

                        <div class="awpr-tools-item col-span-4">

                            <h3 class="font-semibold text-awpr-gray"><?php echo $row_task['title'] ?></h3>

                            <p class="italic mt-1">

                                <?php 

                                    if ( isset($row_task['has_total']) && $row_task['has_total'] == false ) {

                                        echo '';//_e($row_task['has_total'], AWR_PLUGIN_TEXTDOMAIN);

                                    }

                                    else {

                                        _e('Total', AWR_PLUGIN_TEXTDOMAIN); 

                                    }

                                ?>

                                <!-- Loading icon -->

                                <span id="AWR_total_<?php echo $row_task['task'] ?>_loading" type="<?php echo $row_task['task'] ?>" class="icon-sync text-awpr-brand text-xs animate-spin-reverse ml-2 AWR_tools_loading"></span>

                                <span id="AWR_total_<?php echo $row_task['task'] ?>" type="<?php echo $row_task['task'] ?>" class="AWR-item-to-reset-total" style="display:none;">-</span>

                            </p>

                            <div class="flex gap-2 mt-5">

                                <?php print_deals_with_files_db ( $row_task['deals_with_files'], $row_task['deals_with_db'] ); ?>

                            </div>

                        </div>

                        <!-- Right side -->

                        <div class="awpr-tools-desc col-span-8">

                            <p class="text-awpr-gray mb-4"><?php echo $row_task['explanaition']; ?></p>

                            <?php if ( $row_task['task'] == 'themes-files') { ?> 

                                <div class="mb-4">

                                    <label for="awr-keep-current-theme" class="relative inline-flex cursor-pointer items-center gap-2">

                                        <input type="checkbox" name="awr-keep-current-theme" id="awr-keep-current-theme" checked class="peer sr-only" />

                                        <div class="peer h-3.5 w-3.5 rounded-[3px] border-2 border-gray-400 bg-white transition-all peer-checked:border-green-500 peer-checked:bg-green-500"></div>

                                        <span>Keep active theme</span>

                                    </label>

                                </div>

                            <?php } 

                            $button_data = "id='button_for_" . esc_attr($row_task['task']) . "' name='" . esc_attr($row_task['task']) . "' value='" . esc_attr($row_task['title']) . "'"; 

                            $extra_class = '';

                            if ( $is_task_in_pro_only ) {

                                $extra_class = ' in-pro-only ';

                            }

                            if ( !array_key_exists('available', $row_task) || $row_task['available'] != false ) {

                                if ( $row_task['action'] == 'clean' ) { ?>

                                <!-- Clean button -->

                                <button <?php echo $button_data; ?> class="<?php echo $extra_class; ?> AWR-custom-reset-button awpr-button awpr-button-dark">

                                    <span class="icon-clean"></span>

                                    <span class="awpr-icon-separator">|</span>

                                    Clean

                                </button>

                                <?php } else if ( $row_task['action'] == 'delete' ) { ?>

                                <!-- Delete button -->

                                <button <?php echo $button_data; ?> class="<?php echo $extra_class; ?> AWR-custom-reset-button awpr-button awpr-button-danger">

                                    <span class="icon-delete"></span>

                                    <span class="awpr-icon-separator">|</span>

                                    Delete

                                </button>

                                <?php } else if ( $row_task['action'] == 'reset' ) { ?>

                                <!-- Reset button -->

                                <button <?php echo $button_data; ?> class="<?php echo $extra_class; ?> AWR-custom-reset-button awpr-modal-btn awpr-button awpr-button-primary">

                                    <span class="icon-restart text-lg"></span>

                                    <span class="awpr-icon-separator">|</span>

                                    Reset

                                </button>

                            <?php } 

                            } ?>

                            <!-- No action -->

                            <p id="no_action_for_<?php echo esc_attr($row_task['task']); ?>" class="awr-no-action-for-tools text-awpr-gray mb-4">No action to perform</p-->

                        </div>

                    </div>

                    <?php } ?>

                <?php if ($is_bloc_in_pro_only) { 

                    echo $premium_frame_div_end; 

                } ?>

            </div>

        </div>

    </div>

    <?php } ?>