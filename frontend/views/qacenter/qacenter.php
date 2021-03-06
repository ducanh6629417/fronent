<link rel="stylesheet" href="/stores/css/qacenter.css" type="text/css" />

<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.8.3.js"></script>
<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js"></script>

<script language="JavaScript" type="text/javascript">
    document.addEventListener('invalid', (function() {
        return function(e) {
            e.preventDefault();
            document.getElementById("search-qa").focus();
        };
    })(), true);

    $(document).ready(function() {
        $(".chosen_js").chosen();

        var delay = (function() {
            var timer = 0;
            return function(callback, ms) {
                clearTimeout(timer);
                timer = setTimeout(callback, ms);
            };
        })();

        $("#search-qa").keyup(function() {
            delay(function() {
                var keyword = $('#search-qa').val();
                var URL = encodeURI("/qacenter/qacenter?q=" + keyword.trim());
                $.ajax({
                    url: URL,
                    cache: false,
                    type: "GET",
                    success: function(response) {
                        if (response != '') {
                            var par_result = JSON.parse(response);
                            var html_result = '';
                            $.each(par_result, function(key, val) {
                                html_result += '<li>';
                                html_result += '<a href="' + val['url'] + '" target="_blank">' + val['label'];
                                html_result += '</a>';
                                html_result += '</li>';
                            });
                            $('#result_search_qa').html(html_result);
                            $('#result_search_qa').show();
                        } else {
                            $('#result_search_qa').hide();
                        }
                    }
                });
            }, 500);
        });

        $("#search-qa").focusout(function() {
            delay(function() {
                $('#result_search_qa').hide();
            }, 100);
        });

        $('#category_id_submit_chosen').on('click', function(e) {
            var category_id = $('#category_id_submit').val();
            if (category_id != '') {
                $('#category_id_submit_chosen').removeClass('border_error');
                $('#error_category_id').html('');
            }
        });

        $('body').on('focus', '#question', function() {
            $('#question').removeClass('border_error');
            $('#error_question').html('');
        });

        $('body').on('change', '#question', function() {
            var question = $('#question').val().trim();
            if (question != '' && question.length >= 10) {
                $('#question').removeClass('border_error');
                $('#error_question').html('');
            }
        });

        $('#button-submit').on('click', function(e) {
            var error = false;
            var category_id = $('#category_id_submit').val();
            if (category_id == '') {
                $('#category_id_submit_chosen').addClass('border_error');
                $('#error_category_id').html('Vui l??ng ch???n ch??? ?????!');
                error = true;
            } else {
                $('#category_id_submit_chosen').removeClass('border_error');
                $('#error_category_id').html('');
            }
            var question = $('#question').val().trim();
            if (question == '') {
                $('#question').addClass('border_error');
                $('#error_question').html('Vui l??ng nh???p n???i dung c??u h???i!');
                error = true;
            } else if (question.length < 10) {
                $('#question').addClass('border_error');
                $('#error_question').html('Vui l??ng nh???p tr??n 10 k?? t???');
                error = true;
            } else {
                $('#question').removeClass('border_error');
                $('#error_question').html('');
            }
            if (error == false) {
                $.ajax({
                    type: 'POST',
                    url: '/qacenter/qacenter',
                    data: {
                        category_id: category_id,
                        question: question
                    },
                    success: function(response) {
                        $('#form_create_post')[0].reset();
                        $('#category_id_submit').prop('selectedIndex', 0);
                        $('#category_id_submit').trigger('chosen:updated');
                        alert('C??u h???i c???a b???n ???? ???????c g???i th??nh c??ng v?? ??ang ch??? ph?? duy???t');
                    }
                });
            }
        });

        $('.li-tab').click(function() {
            var data_link = $(this).attr('data-link');
            $('.li-tab').removeClass('active');
            $(this).addClass('active');
            var type_tab = $('.li-tab.active').attr('data-link');
            var last_page = <?= $total_page ?>;
            var last_page_popular = <?= $total_page_popular ?>;
            var last_page_not_answer = <?= $total_page_not_answer ?>;
            var page = $(this).attr('rel');
            if ($(this).attr('rel') == '>') {
                page = 2;
            } else if ($(this).attr('rel') == '>>') {
                if (type_tab == 'tab-newest') {
                    page = last_page;
                } else if (type_tab == 'tab-popular') {
                    page = last_page_popular;
                } else if (type_tab == 'tab-not-answer') {
                    page == last_page_not_answer;
                }
            }
            $('.total_tab').removeClass('active');
            $('#' + data_link).addClass('active');
            $('#' + data_link + '-2').addClass('active');
            $('.paginate-tab').removeClass('active');
            $('#' + data_link + '-3').addClass('active');

            $('#' + data_link).fadeIn(0);
            $('#' + data_link + '-2').fadeIn(0);
            $('#' + data_link + '-3').fadeIn(0);
        });

        $('.btn-mobile').click(function() {
            var data_link = $(this).attr('data-link');
            $('.btn-mobile').removeClass('active');
            $(this).addClass('active');
            $('.content_tab ').removeClass('active');
            $('#' + data_link).addClass('active');
        });

        var getUrlParameter = function getUrlParameter(sParam) {
            var sPageURL = window.location.search.substring(1),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                }
            }
            return false;
        };

        $('body').on('change', '#category_id', function() {
            if (getUrlParameter('search-qa') == false) {
                var search_key = '';
            } else {
                var search_key = getUrlParameter('search-qa');
            }
            var page_size = $('#page_size').val();
            var category_id = $(this).val();
            var x = $(this).attr('rel');
            $.ajax({
                url: '/qacenter/qacenter',
                data: {
                    category_id: category_id,
                    search_key: search_key,
                    page_size: page_size,
                },
                type: 'POST',
                success: function(res) {
                    var jsonData = JSON.parse(res);
                    let tmpl = $('#template_qa').html();

                    var rendered = '';
                    $.each(jsonData['lq_newest'], function(key, val) {
                        rendered += Mustache.render(tmpl, val);
                    });
                    $("#tab-newest-2").html(rendered);

                    var rendered_popular = '';
                    $.each(jsonData['lq_popular'], function(key, val) {
                        rendered_popular += Mustache.render(tmpl, val);
                    });
                    $("#tab-popular-2").html(rendered_popular);

                    var rendered_not_answer = '';
                    $.each(jsonData['lq_not_answer'], function(key, val) {
                        rendered_not_answer += Mustache.render(tmpl, val);
                    });
                    $("#tab-not-answer-2").html(rendered_not_answer);

                    $('.sp_total_qa_newest').html(jsonData['total_question']);
                    $('.sp_total_qa_popular').html(jsonData['total_question_popular']);
                    $('.sp_total_qa_not_answer').html(jsonData['total_question_not_answer']);

                    $('#tab-newest-3').html(jsonData['cacul_page']);
                    $('#tab-popular-3').html(jsonData['cacul_page_popular']);
                    $('#tab-not-answer-3').html(jsonData['cacul_page_not_answer']);

                    $('html, body').animate({
                        scrollTop: $(".main-faq-top").offset().top
                    }, 1000);
                }
            });
        });

        $('body').on('change', '#page_size', function() {
            if (getUrlParameter('search-qa') == false) {
                var search_key = '';
            } else {
                var search_key = getUrlParameter('search-qa');
            }
            var category_id = $('#category_id').val();
            var page_size = $(this).val();
            var x = $(this).attr('rel');
            console.log(page_size);
            $.ajax({
                url: '/qacenter/qacenter',
                data: {
                    page_size: page_size,
                    search_key: search_key,
                    category_id: category_id,
                },
                type: 'POST',
                success: function(res) {
                    var jsonData = JSON.parse(res);
                    let tmpl = $('#template_qa').html();

                    var rendered = '';
                    $.each(jsonData['lq_newest'], function(key, val) {
                        rendered += Mustache.render(tmpl, val);
                    });
                    $("#tab-newest-2").html(rendered);

                    var rendered_popular = '';
                    $.each(jsonData['lq_popular'], function(key, val) {
                        rendered_popular += Mustache.render(tmpl, val);
                    });
                    $("#tab-popular-2").html(rendered_popular);

                    var rendered_not_answer = '';
                    $.each(jsonData['lq_not_answer'], function(key, val) {
                        rendered_not_answer += Mustache.render(tmpl, val);
                    });
                    $("#tab-not-answer-2").html(rendered_not_answer);

                    $('.sp_total_qa_newest').html(jsonData['total_question']);
                    $('.sp_total_qa_popular').html(jsonData['total_question_popular']);
                    $('.sp_total_qa_not_answer').html(jsonData['total_question_not_answer']);

                    $('#tab-newest-3').html(jsonData['cacul_page']);
                    $('#tab-popular-3').html(jsonData['cacul_page_popular']);
                    $('#tab-not-answer-3').html(jsonData['cacul_page_not_answer']);

                    $('html, body').animate({
                        scrollTop: $(".main-faq-top").offset().top
                    }, 1000);
                }
            });
        });

        $('body').on('click', '.pager', function() {
            if (getUrlParameter('search-qa') == false) {
                var search_key = '';
            } else {
                var search_key = getUrlParameter('search-qa');
            }
            var category_id = $('#category_id').val();
            var page_size = $('#page_size').val();
            var type_tab = $('.li-tab.active').attr('data-link');

            var last_page = <?= $total_page ?>;
            var last_page_popular = <?= $total_page_popular ?>;
            var last_page_not_answer = <?= $total_page_not_answer ?>;
            var page = $(this).attr('rel');

            $('.img-loading').addClass('loading');

            if ($(this).attr('rel') == '>') {
                page = 2;
            } else if ($(this).attr('rel') == '>>' && type_tab == 'tab-newest') {
                page = last_page;
            } else if ($(this).attr('rel') == '>>' && type_tab == 'tab-popular') {
                page = last_page_popular;
            } else if ($(this).attr('rel') == '>>' && type_tab == 'tab-not-answer') {
                page = last_page_not_answer;
            }

            $.ajax({
                url: '/qacenter/qacenter',
                data: {
                    page: page,
                    category_id: category_id,
                    page_size: page_size,
                    search_key: search_key
                },
                type: 'POST',
                success: function(res) {
                    var jsonData = JSON.parse(res);
                    let tmpl = $('#template_qa').html();

                    var rendered = '';
                    $.each(jsonData['lq_newest'], function(key, val) {
                        rendered += Mustache.render(tmpl, val);
                    });
                    $("#tab-newest-2").html(rendered);

                    var rendered_popular = '';
                    $.each(jsonData['lq_popular'], function(key, val) {
                        rendered_popular += Mustache.render(tmpl, val);
                    });
                    $("#tab-popular-2").html(rendered_popular);

                    var rendered_not_answer = '';
                    $.each(jsonData['lq_not_answer'], function(key, val) {
                        rendered_not_answer += Mustache.render(tmpl, val);
                    });
                    $("#tab-not-answer-2").html(rendered_not_answer);

                    $('#tab-newest-3').html(jsonData['cacul_page']);
                    $('#tab-popular-3').html(jsonData['cacul_page_popular']);
                    $('#tab-not-answer-3').html(jsonData['cacul_page_not_answer']);

                    $('.img-loading').removeClass('loading');

                    $('html, body').animate({
                        scrollTop: $(".main-faq-top").offset().top
                    }, 1000);
                }
            });
        });
        $('.li-tab a').click(function() {
            var url = $(this).attr('dthref');
            if (typeof(history.pushState) != "undefined") {
                var obj = {
                    Title: '',
                    Url: url
                };
                history.pushState(obj, obj.Title, obj.Url);
                $('html, body').animate({
                    scrollTop: $(".main-faq-top").offset().top
                }, 1000);

                // $.ajax({
                //     url: '/qacenter/qacenter',
                //     data: {
                //         page: 1,
                //     },
                //     type: 'POST',
                //     success: function(res) {
                //         var jsonData = JSON.parse(res);
                //         let tmpl = $('#template_qa').html();

                //         var rendered = '';
                //         $.each(jsonData['lq_newest'], function(key, val) {
                //             rendered += Mustache.render(tmpl, val);
                //         });
                //         $("#tab-newest-2").html(rendered);

                //         var rendered_popular = '';
                //         $.each(jsonData['lq_popular'], function(key, val) {
                //             rendered_popular += Mustache.render(tmpl, val);
                //         });
                //         $("#tab-popular-2").html(rendered_popular);

                //         var rendered_not_answer = '';
                //         $.each(jsonData['lq_not_answer'], function(key, val) {
                //             rendered_not_answer += Mustache.render(tmpl, val);
                //         });
                //         $("#tab-not-answer-2").html(rendered_not_answer);

                //         $('#tab-newest-3').html(jsonData['cacul_page']);
                //         $('#tab-popular-3').html(jsonData['cacul_page_popular']);
                //         $('#tab-not-answer-3').html(jsonData['cacul_page_not_answer']);

                //         $('.img-loading').removeClass('loading');

                //         $('html, body').animate({
                //             scrollTop: $(".main-faq-top").offset().top
                //         }, 1000);
                //     }
                // });
            }
        });
    });
</script>

<?php

use frontend\models\QaCategory;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;

?>

<div class="container">
    <div class="breadcrumbs">
        <a href="https://thebank.vn">Trang ch???</a>
        <i></i>
        <span>H???i ????p</span>
    </div>
    <div class="container-faq">
        <div class="tab-mobile">
            <div class="tab-left btn-mobile active" data-link="tab-list-qa">
                <i></i>
                <div class="list-qa-distance"></div>
                <span>C??u h???i th?????ng g???p</span>
            </div>
            <div class="tab-right btn-mobile" data-link="tab-question-qa">
                <i></i>
                <div class="question-qa-distance"></div>
                <span>?????t c??u h???i</span>
            </div>
        </div>
        <div class="faq-center-left content_tab active" id="tab-list-qa">
            <div class="search-faq position-relative">
                <form action="" method="GET">
                    <input type="text" name="search-qa" class="search-qa" id="search-qa" placeholder="H??y t??m c??u tr??? l???i tr?????c khi ?????t c??u h???i..." autocomplete="off" value="<?php if (isset($_GET['search-qa'])) echo $_GET['search-qa'] ?>" required pattern=".*\S+.*">
                    <button type="submit" class="button-search-qa"><i></i></button>
                </form>
                <ul id="result_search_qa">
                </ul>
            </div>
            <div class="title-faq">
                <h1 style="display: none;">H???i ????p th???o lu???n v??? c??c s???n ph???m t??i ch??nh</h1>
                <h2 style="display: none;">H???i ????p th???o lu???n v??? c??c s???n ph???m t??i ch??nh</h2>
                <h3 style="display: none;">H???i ????p th???o lu???n v??? c??c s???n ph???m t??i ch??nh</h3>
                <h4>H???i ????p th???o lu???n v??? c??c s???n ph???m t??i ch??nh</h4>
            </div>
            <div class="hr-faq">
                <hr>
            </div>
            <div class="list-faq">
                <ul class="row">
                    <?php foreach ($qa_category_2 as $item) :
                        $params = Url::to(['qacenter/qacenter', 'category_id' => $item['id'], 'slug' => $this->context->actionSlug($item['name'])]);

                    ?>
                        <li class="col-12 col-md-6">
                            <i></i>
                            <div class="li-faq-distance"></div>
                            <a href="<?= $params ?>" <?php
                                                        if (isset($category_id)) {
                                                            if ($category_id == $item['id']) {
                                                                echo "style='color: #436eb3;'";
                                                            };
                                                        };
                                                        ?> target="_blank">
                                <?php if (strtolower(substr($item['name'], 0, 1)) != substr($item['name'], 0, 1)) echo "H???i ????p " ?>
                                <?= strtolower(substr($item['name'], 0, 1)) ?><?php if (strpos(substr($item['name'], 1), '-')) {
                                                                                    echo substr(substr($item['name'], 1), 0, strpos(substr($item['name'], 1), '-'));
                                                                                } else {
                                                                                    echo substr($item['name'], 1);
                                                                                } ?>
                                (<?= $item['count_question'] ?>)
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="make-request-faq content_tab" id="tab-question-qa">
            <?php $form = ActiveForm::begin([
                'options' => ['enctype' => 'multipart/form-data'],
                'class' => 'question-box',
                'id' => 'form_create_post'
            ]) ?>
            <div class="question-qa">
                <i></i>
                <div class="question-qa-distance"></div>
                <span>?????t c??u h???i</span>
            </div>
            <div class="tips-qa">
                <span>M???o: Ch???n ????ng ch??? ????? s??? gi??p ng?????i kh??c t??m h???i ???????c c??u h???i c???a b???n.</span>
            </div>
            <div class="select-topic-qa">
                <select name="category_id" class="chosen_js" id="category_id_submit">
                    <option value="">Ch???n ch??? ?????</option>
                    <option value="2">Th??? t??n d???ng</option>
                    <option value="12">B???o hi???m nh??n th???</option>
                    <option value="9">Vay t??n ch???p</option>
                    <option value="10">Vay th??? ch???p</option>
                    <option value="21">Vay ti??u d??ng c?? nh??n</option>
                    <option value="24">Vay tr??? g??p</option>
                    <option value="26">Vay mua xe ?? t??</option>
                    <option value="22">Vay mua nh??</option>
                    <option value="3">Vay v???n ng??n h??ng</option>
                    <option value="23">Vay kinh doanh</option>
                    <option value="25">Vay du h???c</option>
                    <option value="13">B???o hi???m s???c kh???e</option>
                    <option value="16">B???o hi???m thai s???n</option>
                    <option value="15">B???o hi???m ?? t??</option>
                    <option value="11">B???o hi???m</option>
                    <option value="18">B???o hi???m y t???</option>
                    <option value="41">B???o hi???m b???nh hi???m ngh??o</option>
                    <option value="19">B???o hi???m phi nh??n th??? kh??c</option>
                    <option value="38">Ng??n h??ng ??i???n t???</option>
                    <option value="27">Th??? ghi n??? n???i ?????a</option>
                    <option value="28">Th??? ghi n??? qu???c t???</option>
                    <option value="30">Th??? h???i vi??n</option>
                    <option value="29">Th??? ?????ng th????ng hi???u</option>
                    <option value="4">Si??u th??? & TT th????ng m???i</option>
                    <option value="5">??i???n m??y v?? n???i th???t</option>
                    <option value="34">???m th???c</option>
                    <option value="37">D???ch v??? kh??c</option>
                </select>
                <span id="error_category_id" class="error_category_id"></span>
            </div>
            <div class="textarea-qa">
                <textarea name="question" id="question" placeholder="Nh???p n???i dung t???i ????y ..."></textarea>
                <span id="error_question" class="error_question"></span>
            </div>
            <div class="button-qa">
                <button type="button" id="button-submit">G???i c??u h???i</button>
            </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>
    <div class="main-faq">
        <div class="main-faq-top">
            <div class="select-box-left">
                <select name="category_id" id="category_id" class="chosen_js">
                    <option value="">L???c b???i danh m???c</option>
                    <?php foreach ($qa_category as $item) {
                    ?>
                        <option value="<?= $item->id ?>" rel="<?= $item->id ?>" <?php if (isset($category_id)) {
                                                                                    if ($category_id == $item['id']) {
                                                                                        echo "selected";
                                                                                    };
                                                                                }; ?>><?= $item->name ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="select-box-right">
                <span>C??u h???i m???i trang</span>
                <select name="page_size" id="page_size" class="chosen_js">
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                    <option value="25">25</option>
                </select>
            </div>
        </div>
        <div class="main-faq-content">
            <div class="total">
                <div class="total_tab <?= $active_default ?>" id="tab-newest">
                    <div class="total_question">
                        <span>C??u h???i</span>
                        <span class="sp_total_qa_newest"><?= $total_question ?></span>
                    </div>
                    <div class="total_member">
                        <span>Th??nh vi??n</span>
                        <span>2.833.878</span>
                    </div>
                </div>
                <div class="total_tab <?= $active_pb ?>" id="tab-popular">
                    <div class="total_question">
                        <span>C??u h???i</span>
                        <span class="sp_total_qa_popular"><?= $total_question_popular ?></span>
                    </div>
                    <div class="total_member">
                        <span>Th??nh vi??n</span>
                        <span>2.833.878</span>
                    </div>
                </div>
                <div class="total_tab <?= $active_notans ?>" id="tab-not-answer">
                    <div class="total_question">
                        <span>C??u h???i</span>
                        <span class="sp_total_qa_not_answer"><?= $total_question_not_answer ?></span>
                    </div>
                    <div class="total_member">
                        <span>Th??nh vi??n</span>
                        <span>2.833.878</span>
                    </div>
                </div>
            </div>

            <ul class="nav-tabs" id="nav-tabs">
                <li class="tab-newest li-tab <?= $active_default ?>" data-link="tab-newest">
                    <a href="javascript:;" dthref="<?= $current_url ?>.html">M???i nh???t</a>
                </li>
                <li class="tab-popular li-tab <?= $active_pb ?>" data-link="tab-popular">
                    <a href="javascript:;" dthref="<?= $current_url ?>/pho-bien.html">Ph??? bi???n</a>
                </li>
                <li class="tab-not-answer li-tab <?= $active_notans ?>" data-link="tab-not-answer">
                    <a href="javascript:;" dthref="<?= $current_url ?>/chua-co-tra-loi.html">Ch??a c?? tr??? l???i</a>
                </li>
            </ul>
            <div class="list-question">
                <ul class="ul_question total_tab <?= $active_default ?>" id="tab-newest-2">
                    <?php foreach ($lq_newest as $item) :
                        $url = Url::to(['qacenter/qacenter', 'category_id' => $item['category_id'], 'slug' => $this->context->actionSlug(isset($arr_cate[$item['category_id']]) ? $arr_cate[$item['category_id']] : '')]);
                    ?>
                        <li class="row li_question">
                            <div class="col-md-8 d-block d-md-flex">
                                <img src="/stores/images/qacenter/avatar.png" alt="avatar" class="img-circle">
                                <img src="/stores/images/qacenter/avatar-mobile.png" alt="avatar_mobile" class="img-circle-mobile">
                                <div class="question_from_member_left">
                                    <p>
                                        <a href="javascript:;"><?= $item['user_name'] ?></a> h???i:
                                    </p>
                                    <a href="https://thebank.vn/hoi-dap-faq/<?= $item['category_id'] ?>-<?= isset($arr_cate[$item['category_id']]) ? $this->context->actionSlug($arr_cate[$item['category_id']]) : '' ?>/<?= $item['id'] ?>-<?= $this->context->actionSlug($item['question']); ?>.html" target="_blank">
                                        <span><?= $item['question'] ?></span>
                                    </a>
                                    <hr>
                                    <div class="li-statistics">
                                        <p>???????c h???i v??o <?= $item['date_create'] ?> m???c
                                            <a href="<?= $url ?>" target="_blank"><?= isset($arr_cate[$item['category_id']]) ? $arr_cate[$item['category_id']] : '' ?></a>
                                        </p>
                                        <div class="statistics-mobile d-flex d-md-none">
                                            <div class="statistics-views-mobile">
                                                <i></i>
                                                <span><?= $item['viewed'] ?></span>
                                            </div>
                                            <div class="statistics-replies-mobile">
                                                <i></i>
                                                <span><?= $item['nums_user_answer'] ?></span>
                                            </div>
                                            <div class="statistics-likes-mobile">
                                                <i></i>
                                                <span>0</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="question_from_member_right d-none d-md-flex">
                                    <div class="statistics-views">
                                        <p><?= $item['viewed'] ?></p>
                                        <span class="roboto-light">L?????t xem</span>
                                    </div>
                                    <div class="statistics-replies">
                                        <p><?= $item['nums_user_answer'] ?></p>
                                        <span class="roboto-light">Tr??? l???i</span>
                                    </div>
                                    <div class="statistics-likes">
                                        <p>0</p>
                                        <span class="roboto-light">L?????t th??ch</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <ul class="ul_question total_tab <?= $active_pb ?>" id="tab-popular-2">
                    <?php foreach ($lq_popular as $item) :
                        $url = Url::to(['qacenter/qacenter', 'category_id' => $item['category_id'], 'slug' => $this->context->actionSlug(isset($arr_cate[$item['category_id']]) ? $arr_cate[$item['category_id']] : '')]);
                    ?>
                        <li class="row li_question">
                            <div class="col-md-8 d-block d-md-flex">
                                <img src="/stores/images/qacenter/avatar.png" alt="avatar" class="img-circle">
                                <img src="/stores/images/qacenter/avatar-mobile.png" alt="avatar_mobile" class="img-circle-mobile">
                                <div class="question_from_member_left">
                                    <p>
                                        <a href="javascript:;" target="_blank"><?= $item['user_name'] ?></a> h???i:
                                    </p>
                                    <a href="https://thebank.vn/hoi-dap-faq/<?= $item['category_id'] ?>-<?= isset($arr_cate[$item['category_id']]) ? $this->context->actionSlug($arr_cate[$item['category_id']]) : '' ?>/<?= $item['id'] ?>-<?= $this->context->actionSlug($item['question']);  ?>.html" target="_blank">
                                        <span><?= $item['question'] ?></span>
                                    </a>
                                    <hr>
                                    <div class="li-statistics">
                                        <p>???????c h???i v??o <?= $item['date_create'] ?> m???c
                                            <a href="<?= $url ?>" target="_blank"><?= isset($arr_cate[$item['category_id']]) ? $arr_cate[$item['category_id']] : '' ?></a>
                                        </p>
                                        <div class="statistics-mobile d-flex d-md-none">
                                            <div class="statistics-views-mobile">
                                                <i></i>
                                                <span><?= $item['viewed'] ?></span>
                                            </div>
                                            <div class="statistics-replies-mobile">
                                                <i></i>
                                                <span><?= $item['nums_user_answer'] ?></span>
                                            </div>
                                            <div class="statistics-likes-mobile">
                                                <i></i>
                                                <span>0</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="question_from_member_right d-none d-md-flex">
                                    <div class="statistics-views">
                                        <p><?= $item['viewed'] ?></p>
                                        <span class="roboto-light">L?????t xem</span>
                                    </div>
                                    <div class="statistics-replies">
                                        <p><?= $item['nums_user_answer'] ?></p>
                                        <span class="roboto-light">Tr??? l???i</span>
                                    </div>
                                    <div class="statistics-likes">
                                        <p>0</p>
                                        <span class="roboto-light">L?????t th??ch</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <ul class="ul_question total_tab <?= $active_notans ?>" id="tab-not-answer-2">
                    <?php foreach ($lq_not_answer as $item) :
                        $url = Url::to(['qacenter/qacenter', 'category_id' => $item['category_id'], 'slug' => $this->context->actionSlug(isset($arr_cate[$item['category_id']]) ? $arr_cate[$item['category_id']] : '')]);
                    ?>
                        <li class="row li_question">
                            <div class="col-md-8 d-block d-md-flex">
                                <img src="/stores/images/qacenter/avatar.png" alt="avatar" class="img-circle">
                                <img src="/stores/images/qacenter/avatar-mobile.png" alt="avatar_mobile" class="img-circle-mobile">
                                <div class="question_from_member_left">
                                    <p>
                                        <a href="javascript:;" target="_blank"><?= $item['user_name'] ?></a> h???i:
                                    </p>
                                    <a href="https://thebank.vn/hoi-dap-faq/<?= $item['category_id'] ?>-<?= isset($arr_cate[$item['category_id']]) ? $this->context->actionSlug($arr_cate[$item['category_id']]) : '' ?>/<?= $item['id'] ?>-<?= $this->context->actionSlug($item['question']);  ?>.html" target="_blank">
                                        <span><?= $item['question'] ?></span>
                                    </a>
                                    <hr>
                                    <div class="li-statistics">
                                        <p>???????c h???i v??o <?= $item['date_create'] ?> m???c
                                            <a href="<?= $url ?>" target="_blank"><?= isset($arr_cate[$item['category_id']]) ? $arr_cate[$item['category_id']] : '' ?></a>
                                        </p>
                                        <div class="statistics-mobile d-flex d-md-none">
                                            <div class="statistics-views-mobile">
                                                <i></i>
                                                <span><?= $item['viewed'] ?></span>
                                            </div>
                                            <div class="statistics-replies-mobile">
                                                <i></i>
                                                <span><?= $item['nums_user_answer'] ?></span>
                                            </div>
                                            <div class="statistics-likes-mobile">
                                                <i></i>
                                                <span>0</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="question_from_member_right d-none d-md-flex">
                                    <div class="statistics-views">
                                        <p><?= $item['viewed'] ?></p>
                                        <span class="roboto-light">L?????t xem</span>
                                    </div>
                                    <div class="statistics-replies">
                                        <p><?= $item['nums_user_answer'] ?></p>
                                        <span class="roboto-light">Tr??? l???i</span>
                                    </div>
                                    <div class="statistics-likes">
                                        <p>0</p>
                                        <span class="roboto-light">L?????t th??ch</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="paginate">
                <img src="/stores/images/qacenter/loading-page.gif" class="img-loading" alt="img_loading">
                <div class="paginate-faq paginate-tab active" id="tab-newest-3">
                    <?php foreach ($list_li as $item) : ?>
                        <a href="javascript:void(0)" class="pager" rel="<?= $item['page'] ?>"><?= $item['page'] ?></a>
                    <?php endforeach; ?>
                </div>
                <div class="paginate-faq paginate-tab" id="tab-popular-3">
                    <?php foreach ($list_li_popular as $item) : ?>
                        <a href="javascript:void(0)" class="pager" rel="<?= $item['page'] ?>"><?= $item['page'] ?></a>
                    <?php endforeach; ?>
                </div>
                <div class="paginate-faq paginate-tab" id="tab-not-answer-3">
                    <?php foreach ($list_li_not_answer as $item) : ?>
                        <a href="javascript:void(0)" class="pager" rel="<?= $item['page'] ?>"><?= $item['page'] ?></a>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </div>
</div>

<script id="template_pager" type="x-tmpl-mustache">
    <a href="javascript:void(0)" class="pager" rel={{page}}>{{page}}</a>
</script>

<script id="template_qa" type="x-tmpl-mustache">
    <li class="row li_question">
        <div class="col-md-8 d-block d-md-flex">
            <img src="/stores/images/qacenter/avatar.png" alt="avatar" class="img-circle">
            <img src="/stores/images/qacenter/avatar-mobile.png" alt="avatar_mobile" class="img-circle-mobile">
            <div class="question_from_member_left">
                <p>
                    <a href="javascript:;">{{user_name}}</a> h???i:
                </p>
                <a href={{url_question}} target="_blank">
                    <span>{{question}}</span>
                </a>
                <hr>
                <div class="li-statistics">
                    <p>???????c h???i v??o {{date_create}} m???c
                        <a href="{{href}}" target="_blank">{{category_name}}</a>
                    </p>
                    <div class="statistics-mobile d-flex d-md-none">
                        <div class="statistics-views-mobile">
                            <i></i>
                            <span>{{viewed}}</span>
                        </div>
                        <div class="statistics-replies-mobile">
                            <i></i>
                            <span>{{nums_user_answer}}</span>
                        </div>
                        <div class="statistics-likes-mobile">
                            <i></i>
                            <span>0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="question_from_member_right d-none d-md-flex">
                <div class="statistics-views">
                    <p>{{viewed}}</p>
                    <span class="roboto-light">L?????t xem</span>
                </div>
                <div class="statistics-replies">
                    <p>{{nums_user_answer}}</p>
                    <span class="roboto-light">Tr??? l???i</span>
                </div>
                <div class="statistics-likes">
                    <p>0</p>
                    <span class="roboto-light">L?????t th??ch</span>
                </div>
            </div>
        </div>
    </li>
</script>