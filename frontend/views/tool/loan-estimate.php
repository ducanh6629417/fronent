<link rel="stylesheet" href="/stores/css/loan-estimate.css" type="text/css">
<style type="text/css">
    .nav {
        margin-bottom: 0
    }

    .tab-content {
        overflow: unset
    }

    .modal.fade.in {
        top: 0
    }

    #modalCarLoanRepayment {
        z-index: 25000;
        width: 900px
    }

    .modal-backdrop {
        z-index: 23000
    }

    .modal {
        background-color: transparent;
    }

    .icon_meet_supplier img {
        margin-left: 4px;
        margin-top: 4px;
    }

    #modalCarLoanRepayment .modal-header {
        background-color: #fff;
        padding: 15px 15px;
        border: 0;
        margin-bottom: -1px;
    }

    #modalCarLoanRepayment .modal-body {
        padding: 0 !important;
        background-color: #fff;
    }

    #modalCarLoanRepayment .modal-dialog {
        width: auto !important
    }

    .modal-open .modal {
        overflow: hidden;
    }

    #modalCarLoanRepayment.modal {
        bottom: auto
    }

    #modalCarLoanRepayment td {
        text-align: left !important;
        border: 0 !important;
        font-weight: 500;
        text-indent: 10px;
    }

    #modalCarLoanRepayment .table-striped {
        margin-bottom: -1px;
        border: 0;
    }

    #modalCarLoanRepayment .modal-accordion td {
        font-weight: 400;
    }

    .calculator-info .modal-dialog .accordion-mini>.accordion-title h4 {
        font-size: 16px;
        font-weight: 500
    }

    .calculator-info .modal-dialog .accordion-mini {
        margin-top: 0;
    }
</style>

<script>
    var PERSONAL_LOAN_CAL_DATA = {
        config: {
            single: true,
            business: false,
            sign: 'VND',
            lang: 'vi'
        },
        data: [{
            id: 'prod_personal1_1m',
            name: 'Loan secured by valuable paper (term < 12 month)',
            borrow: {
                monthly_income: {
                    min: 0,
                    max: 300000000,
                    unit: 'VND',
                    step: 1,
                    value: 0
                },
                monthly_expenses: {
                    min: 0,
                    max: 300000000,
                    unit: 'VND',
                    step: 1,
                    value: 0
                },
                loan_term: { // months
                    min: 0,
                    max: 25,
                    step: 1,
                    value: 0
                }
            },
            repayment: {
                borrow_amount: {
                    min: 0,
                    max: 5000000000,
                    unit: 'VND',
                    step: 1,
                    value: 0
                },
                loan_term: {
                    min: 0,
                    max: 25,
                    step: 1,
                    value: 0
                }
            }
        }]
    }
</script>
<div class="container main-loan-container">
    <div class="main_loan ">
        <div class="breadcrumbs" id="breadcrumbs_loan">
            <a href="https://thebank.vn">Trang ch???</a>
            <i></i>
            <a href="https://thebank.vn/cong-cu.html">C??ng c???</a>
            <i></i>
            <span>?????c t??nh s??? ti???n c?? th??? vay</span>
        </div>
        <div class="box-heading ">
            <div class="header_caculator">
                <h1 class="title-main">C??ng c??? ?????c t??nh s??? ti???n c?? th??? vay</h1>
                <p class="roboto-light descript_page">C??ng c??? gi??p b???n t??nh ngay ???????c s??? ti???n c?? th??? vay ???????c d???a tr??n m???c thu nh???p h??ng th??ng, m???c chi ti??u h??ng th??ng, k??? h???n vay v?? l??i su???t vay.</p>
                <div class="bottom_content_page animated">
                    <section class="accordion-main alive  saving-account-landing saving-personal-calculator " id="personal-loan-borrow">
                        <div class="saving-cal" data-name="saving-cal" data-type="personal">
                            <div class=" range-calculotor">
                                <div class="div_left">
                                    <div class="value-label roboto-light">Thu nh???p h??ng th??ng</div>
                                    <input type="tel" autocomplete="off" name="monthly_income" class="value-current income" pattern="integer" data-toggle="tooltip" data-placement="top" title="Nh???p gi?? tr???" />
                                </div>
                                <div class="div_right calculator-container calculator-container-saving">
                                    <div class="calculator-wraper">
                                        <div class="range-container">
                                            <input type="range" value="0" min="0" max="300000000" unit="VND" million='true' name="monthly_income" data-placement="top" title="Ch???n gi?? tr???" data-single="true" data-have-tooltip="true" data-mt-max="true" />
                                            <div class="min-max-value">
                                                <span class="min-value"></span>
                                                <span class="max-value"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="range-calculotor">
                                <div class="div_left">
                                    <div class="value-label roboto-light">Chi ti??u h??ng th??ng</div>
                                    <input type="tel" class="value-current expenses" />
                                </div>
                                <div class="div_right calculator-container">
                                    <div class="calculator-wraper">
                                        <div class="range-container range-loan-termh">
                                            <input type="range" autocomplete="off" name="monthly_expenses" value="0" min="0" max="300000000" unit="VND" million='true' name='monthly_expenses' data-mt-max="true">
                                            <div class="min-max-value">
                                                <span class="min-value"></span>
                                                <span class="max-value"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="range-calculotor">
                                <div class="div_left">
                                    <div class="value-label roboto-light">K??? h???n vay</div>
                                    <input type="tel" autocomplete="off" class="value-current term" pattern="integer" />
                                </div>
                                <div class="div_right calculator-container">
                                    <div class="calculator-wraper">
                                        <div class="range-container range-loan-termh">
                                            <input class=" term" name="term" type="range" value="0" min="0" data-name="input-deposit-term" data-value="0" max="25" unit="n??m" name='term' data-mt-max="true">
                                            <div class="min-max-value">
                                                <span class="min-value"></span>
                                                <span class="max-value"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="range-interest ">
                                <div class="div_left " id="lx">
                                    <div class="value-label roboto-light">L??i su???t</div>
                                    <input type="tel" autocomplete="off" id="interest" class="interest value-current number-input" data-value="" value="0%/n??m" data-suffix="%/n??m" pattern="amount" />
                                </div>
                                <p class=" d-none ">(*) C??ng c??? t??nh to??n tr??n website ch??? mang t??nh ch???t tham kh???o.</p>
                                <div class="div_right result_final info-block">
                                    <div class="calculator-info-result centered">
                                        <div>
                                            <span class="roboto-light">S??? ti???n c?? th??? vay</span> <b class="d-none d-lg-block">:</b>
                                            <span class="value-info amount-borrow">0 VND</span>
                                        </div>
                                    </div>
                                </div>
                                <p class="note_rate d-none d-lg-block">(*) C??ng c??? t??nh to??n tr??n website ch??? mang t??nh ch???t tham kh???o.</p>
                               
                                <h2 class="d-none">C??NG C??? ?????C T??NH S??? TI???N C?? TH??? VAY</h2>
                                <h3 class="d-none">????ng nh???p</h3>
                                <h3></h3>
                                <h3 class="d-none">X??c th???c m?? OTP</h3>
                                <h3 class="d-none">X??c th???c m?? OTP</h3>
                                <h4 class="d-none">Ch??o bu???i s??ng, ch??o m???ng b???n quay l???i :)</h4>
                                <h4></h4>
                                <h4 class="d-none">Modal title</h4>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/stores/js/tool/loan/polyfills.js"></script>
<script src="/stores/js/tool/loan/jquery.rangeslider.js"></script>
<script src="/stores/js/tool/loan/rangeslider.js"></script>
<script src="/stores/js/tool/loan/global-config.js"></script>
<script src="/stores/js/tool/loan/saving-cal-personal.js"></script>
<script src="/stores/js/tool/loan/input.js"></script>
<!-- <script src="/stores/js/tool/loancalculator.js"></script> -->
<script src="/stores/js/tool/loan/loan-calculator.js"></script>

<script>
    $(document).ready(function() {
        var url = window.location.href;
        $('.value-info').click(function() {
            var data = $(this).html();
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    data: data
                },
                async: false,
                success: function(res) {

                }

            });
        });

        // $('.amount_input').focusout(function(){
        //     var value = $('.amount_input').attr('data-value');
        //     if(value < 1000) {
        //         $('.amount_input').attr("data-value","1000")
        //     }
        //     console.log(value);
        // });
        (function($) {
            $.fn.inputFilters = function(inputFilters) {
                return this.on("input keydown", function() {
                    if (inputFilters(this.value)) {
                        this.oldValue = this.value;
                        this.oldSelectionStart = this.selectionStart;
                        this.oldSelectionEnd = this.selectionEnd;
                    } else if (this.hasOwnProperty("oldValue")) {
                        this.value = this.oldValue;
                        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                    } else {
                        this.value = "";
                    }
                });
            };
        }(jQuery));
        // Install input filters.

        $(".income").inputFilters(function(value) {
            return /^\d*$/.test(value);
        });
        $(".expenses").inputFilters(function(value) {
            return /^\d*$/.test(value);
        });

        $(".amount_input").inputFilters(function(value) {
            return /^[0-9]*\.?[0-9]*$/.test(value);
        });

        (function($) {
            $.fn.inputFilter2 = function(inputFilter2) {
                return this.on("input keydown", function() {
                    if (inputFilter2(this.value)) {
                        this.oldValue = this.value;
                        this.oldSelectionStart = this.selectionStart;
                        this.oldSelectionEnd = this.selectionEnd;
                    } else if (this.hasOwnProperty("oldValue")) {
                        this.value = this.oldValue;
                        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                    } else {
                        this.value = "";
                    }
                });
            };
        }(jQuery));
        // Install input filters.
        $(".term").inputFilter2(function(value) {
            return /^[0-9]*?[0-9]*$/.test(value);
        });


        (function($) {
            $.fn.inputFilter = function(inputFilter) {
                return this.on("input keydown", function() {
                    if (inputFilter(this.value)) {
                        this.oldValue = this.value;
                        this.oldSelectionStart = this.selectionStart;
                        this.oldSelectionEnd = this.selectionEnd;
                    } else if (this.hasOwnProperty("oldValue")) {
                        this.value = this.oldValue;
                        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                    } else {
                        this.value = "";
                    }
                });
            };
        }(jQuery));
        // Install input filters.

        $(".interest").inputFilter(function(value) {
            return /^(?!,)[0-9]{0,2}[,]?[0]{0,1}[1-9]{0,2}$/.test(value);
        });
        // $(".number-input").inputFilter(function(value) {
        // return /^(?!\,)\d*[,]?\d*$/.test(value); }); 


        $('.value-current').focus(function() {
            if ($(this).val() == 0) {
                $(this).val("");
            }
        });



    });
</script>