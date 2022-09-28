<?php

function site_scripts() {
    //*** JS ***//
    wp_enqueue_script( 'jq', get_template_directory_uri() . '/assets/js/jquery-3.3.1.min.js', [], false, true);
    wp_enqueue_script( 'gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.2/gsap.min.js', [], false, true);
    wp_enqueue_script( 'ScrollTrigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.2/ScrollTrigger.min.js', [], false, true);
    wp_enqueue_script( 'yandexApi', 'https://api-maps.yandex.ru/2.1/?lang=ru_RU', [], false, true);
    wp_enqueue_script( 'jqsmoothscroll', get_template_directory_uri() . '/assets/js/jq.smoothscroll.js', [], false, true);
    wp_enqueue_script( 'jqmask', get_template_directory_uri() . '/assets/js/jquery.maskedinput.min.js', [], false, true);
    wp_enqueue_script( 'mainjs', get_template_directory_uri() . '/assets/js/main.js', [], false, true);
    wp_enqueue_script( 'lpfhjs', get_template_directory_uri() . '/assets/js/lpformhandler.min.js', [], false, true);

    //*** Stylesheets ***//
    wp_enqueue_style('MuseoSans', get_template_directory_uri() . '/assets/fonts/MuseoSans/stylesheet.css');
    wp_enqueue_style('PlayFair', get_template_directory_uri() . '/assets/fonts/playfair/playfair.css');
    wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/style.css');
    wp_enqueue_style('lpfhcss', get_template_directory_uri() . '/assets/css/lpformhandler.min.css');
}
add_action('wp_enqueue_scripts', 'site_scripts');


function form_handler(){
    if(empty($_POST)) {
        return;
    }
    else {
        header('Location: ./thankyou/');

        $res = [];

        $email1 = get_option('mail_send_email_1');
        $email2 = get_option('mail_send_email_2');
//        $email3 = get_option('mail_send_email_3');

        $emails = [$email1, $email2];
//        $emailfrom = get_option('mail_email_from');
        $companyfrom = get_option('mail_company_from');
        require  __DIR__ . '/sendmail.php';

//        debug($res)
    }
}
add_action('wp', 'form_handler');

add_theme_support('post-thumbnails');

function my_myme_types($mime_types){
    $mime_types['svg'] = 'image/svg+xml'; // поддержка SVG
    return $mime_types;
}
add_filter('upload_mimes', 'my_myme_types', 1, 1);

if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title'  => 'Основные настройки темы',
        'menu_title' => 'Настройки темы',
        'menu_slug'  => 'theme-general-settings',
        'capability' => 'edit_posts',
        'position'     => 6,
        'redirect'  => false
    ));

}

// Добавляем стили в админку для ACF
add_action('admin_head', function(){ ?>

    <style type="text/css">
        .acf-field-object-tab{
            background: aliceblue;
            box-sizing: border-box;
            border: 3px solid transparent;
        }

        .acf-tab-wrap.-left .acf-tab-group,
        .acf-fields.-sidebar:before {
            width: 200px;
        }

        .acf-fields.-sidebar {
            padding-left: 200px !important;
        }

        .acf-tab-wrap.-left .acf-tab-group li a{
            background: #f9f9f9;
        }

        #titlediv .inside span{
            display:inline-block;
            margin: 5px;
            padding: 5px;
            background: #dbdbdb;
            cursor: pointer;
        }

      /****/

      .styled-inp {
        height: 40px;
        width: 300px;
        border-radius: 5px;
        padding-left: 15px;
        margin: 10px 0 10px;
        display: block;
      }
    </style>

    <script type="text/javascript">

        jQuery(document).ready(function($){

            var boxQuickLinks = $('#titlediv .inside');
            var boxTabs = $('.acf-field-object-tab');
            var QuickLinks = '';

            // Создаем меню из табов
            $(boxTabs).each(function(i){

                var key = $(this).data('key');
                var span = '<span>' + $('.li-field-label strong', this).text() + '</span>';

                $(boxQuickLinks).append( $(span).attr('key', key) );

            });


            // Создаем скролл по клику span->tab
            $('#titlediv .inside').on('click', 'span', function() {

                var key = $(this).attr('key');
                var goTab = $('div[data-key='+ key +']');

                console.log(goTab);

                $("html,body").animate({
                        scrollTop: goTab.offset().top - 200
                    },
                    300,
                    null,
                    function(){

                        goTab
                            .animate({
                                borderColor: "#bfe1ff"
                            }, 500)
                            .animate({
                                borderColor: "transparent"
                            }, 500, 'linear')
                            .stop();

                    });

            });

        });

    </script>

<? });

// action function for above hook
function ext_page_settings() {
    // Add a new top-level menu (ill-advised):
    add_menu_page('Общее', 'Настройки почты', 8, __FILE__, 'ext_form_handler_page');
}
add_action('admin_menu', 'ext_page_settings');

// mt_toplevel_page() displays the page content for the custom Test Toplevel menu
function ext_form_handler_page() {
    $opt_email1 = 'mail_send_email_1';
    $opt_email2 = 'mail_send_email_2';
//    $opt_email3 = 'mail_send_email_3';
//    $opt_efrom = 'mail_email_from';
    $opt_cfrom = 'mail_company_from';
    $hidden_field_name = 'sec_submit_hidden';
    $data_field_name1 = 'email1';
    $data_field_name2 = 'email2';
//    $data_field_name3 = 'email3';
    $data_field_efrom = 'efrom';
    $data_field_cfrom = 'cfrom';

    // Read in existing option value from database
    $email1_val = get_option( $opt_email1 );
    $email2_val = get_option( $opt_email2 );
//    $email3_val = get_option( $opt_email3 );
//    $efrom_val  = get_option( $opt_efrom );
    $cfrom_val  = get_option( $opt_cfrom );

    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( $_POST[ $hidden_field_name ] == 'Y' ) {
        // Read their posted value
        $field_email1_val = strtolower(trim($_POST[ $data_field_name1 ]));
        $field_email2_val = strtolower(trim($_POST[ $data_field_name2 ]));
//        $field_email3_val = strtolower(trim($_POST[ $data_field_name3 ]));
        $field_efrom_val = strtolower(trim($_POST[ $data_field_efrom ]));
        $field_cfrom_val = strtolower(trim($_POST[ $data_field_cfrom ]));

        // Save the posted value in the database
        update_option( $opt_email1, $field_email1_val );
        update_option( $opt_email2, $field_email2_val );
//        update_option( $opt_email3, $field_email3_val );
//        update_option( $opt_efrom, $field_efrom_val );
        update_option( $opt_cfrom, $field_cfrom_val );

        // Put an options updated message on the screen
        $email1_val = $field_email1_val;
        $email2_val = $field_email2_val;
        ?>
      <div class="updated"><p><strong><?php _e('Сохранено', 'mt_trans_domain' ); ?></strong></p></div>
        <?php

    }
  ?>
  <h2>Настройки почты для заявок</h2>
  <form name="settings-form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
    <h4>E-mail'ы для рассылки</h4>
    <input type="hidden" name="<?= $hidden_field_name; ?>" value="Y">
    <input type="text" id="email1" name="<?= $data_field_name1; ?>" value="<?= $email1_val; ?>"
           placeholder="Введите Email для рассылки" class="styled-inp">
    <input type="text" id="email2" name="<?= $data_field_name2; ?>" value="<?= $email2_val; ?>"
           placeholder="Введите Email для рассылки" class="styled-inp">
    <?/*
    <input type="text" id="email3" name="<?= $data_field_name3; ?>" value="<?= $field_email3_val ? $field_email3_val : $email3_val; ?>"
       placeholder="Введите Email для рассылки" class="styled-inp">
    */?>

    <h4>От кого:</h4>
    <?/*
    <input type="text" id="efrom" name="<?= $data_field_efrom; ?>" value="<?= $field_efrom_val ? $field_efrom_val : $efrom_val; ?>"
           placeholder="Введите Email для обратной связи" class="styled-inp">
    */?>
    <input type="text" id="cfrom" name="<?= $data_field_cfrom; ?>" value="<?= $field_cfrom_val ? $field_cfrom_val : $cfrom_val; ?>"
           placeholder="Введите название компании" class="styled-inp">
    <p class="submit">
      <input type="submit" name="submit" class="button-primary" value="Сохранить" />
    </p>
  </form>
  <?
}

function debug($var) {
    echo '<pre>' . print_r($var, true) . '</pre>';
}

function pasteForm(){
	ob_start();
	?>
        <form method="post" class="form form_shortcode">
            <input type="text" name="pagefrom" value="" hidden>
            <input type="text" name="pagefromlink" value="" hidden>
            <input type="text" name="formname" value="Awesome Form" hidden>
            <input type="text" name="date" value="" hidden>
            <input type="text" name="referal" value="" hidden>
            <input type="text" name="utm_source" value="" hidden>
            <input type="text" name="utm_campaign" value="" hidden>
            <input type="text" name="utm_content" value="" hidden>
            <input type="text" name="utm_term" value="" hidden>
            <input type="text" name="easydata" class="easy-breezy">
            <div class="form-cta__top">
                <p>Требуется <span><? wp_title(); ?>?</span> <br>
                    Оставьте заявку и мы вам перезвоним</p>
            </div>
            <div class="form-cta__bottom">
                <div class="placeholder-container">
                    <input type="text" name="phone" placeholder=" " data-required>
                    <label for="phone">Ваш нормер телефона</label>
                </div>
                <div class="placeholder-container">
                    <input type="text" name="name" placeholder=" ">
                    <label for="name">Имя</label>
                </div>
                <div class="group-btn">
                    <button class="btn btn-form" type="submit">Обратиться к нам</button>
                </div>
                <p class="form__politic">Нажимая на кнопку вы соглашаетесь с <a href="#">обработкой персональных данных</a></p>
            </div>
        </form>
    <?php

	return ob_get_clean();
}
add_shortcode('form_content', 'pasteForm');