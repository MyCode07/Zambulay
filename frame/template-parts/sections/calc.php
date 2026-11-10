<section class="section calc" data-tabs-area>
    <div class="calc-bgi">
        <img src="<?php echo esc_url(frame_asset('img/calc-bgi.png')); ?>" alt="">
    </div>
    <div class="section__container _container">
        <div class="section__body">
            <div class="section__top">
                <h2>Управляй финансами в Zambulay</h2>
                <div class="tab-btns">
                    <button data-tab="0" class="_active">Виртуальная карта</button>
                    <button data-tab="1" class="">Кредиты</button>
                    <button data-tab="2" class="">Вклады</button>
                </div>
            </div>
            <div class="tab-contnet">
                <div class="calc-item calc-item__card _active" data-tab-content="0">
                    <div class="grid grid-2">
                        <div class="calc-item__content">
                            <div class="img">
                                <img src="<?php echo esc_url(frame_asset('img/virt-card.svg')); ?>" alt="">
                            </div>
                            <ol>
                                <li>
                                    <img src="<?php echo esc_url(frame_asset('img/icons/doc.svg')); ?>" alt="">
                                    <span>Оформление без KYC.</span>
                                </li>
                                <li>
                                    <img src="<?php echo esc_url(frame_asset('img/icons/usdt.svg')); ?>" alt="">
                                    <span>Пополнение через USDT (TRC-20).</span>
                                </li>
                                <li>
                                    <img src="<?php echo esc_url(frame_asset('img/icons/mint.svg')); ?>" alt="">
                                    <span>Стоимость выпуска $3.</span>
                                </li>
                            </ol>
                        </div>
                        <div class="form form-succsess">
                            <div class="icon">
                                <img src="<?php echo esc_url(frame_asset('img/usersuccess.png')); ?>" alt="">
                            </div>
                            <div class="form__title">
                                <h4>Мы Вас узнали</h4>
                                <p>Войдите в личный кабинет,<br> чтобы продолжить</p>
                            </div>
                            <a href="" target="_blank" class="_btn _btn-black">Войти</a>
                        </div>
                    </div>
                </div>
                <div class="calc-item calc-item__credit " data-tab-content="1">
                    <div class="grid grid-2">
                        <div class="calc-item__content">
                            <div class="calc-func">
                                <h4>Рассчитайте платеж</h4>
                                <div class="input-range">
                                    <p>Cумма кредита</p>
                                    <div class="input-range__output">
                                        <div class="current-value">
                                            <span>10 000 </span> USD
                                        </div>
                                        <div class="max-value">
                                            до <span>300 000</span> USD
                                        </div>
                                    </div>
                                    <input type="range" name="credit-value" min="10000" max="300000" value="100"
                                        step="100">
                                </div>
                                <div class="input-range">
                                    <p>Срок кредита</p>
                                    <div class="input-range__output">
                                        <div class="current-value">
                                            <span>10 </span> дней
                                        </div>
                                        <div class="max-value">
                                            до <span>120 </span> дней
                                        </div>
                                    </div>
                                    <input type="range" name="credit-period" min="10" max="120" value="10" step="1">
                                </div>
                                <div class="calc-func__total">
                                    <div class="total-value">
                                        <div><label>105 000</label> USD</div>
                                        <span>Сумма к возврату</span>
                                        <input type="hidden" name="credit-total" readonly value="105 000 USD">
                                    </div>
                                    <div class="total-percent">
                                        <div><label>5</label>%</div>
                                        <span>Процентная ставка</span>
                                        <input type="hidden" name="credit-percents" readonly value="5%">
                                    </div>
                                </div>
                            </div>
                            <ol>
                                <li>
                                    <img src="<?php echo esc_url(frame_asset('img/icons/doc.svg')); ?>" alt="">
                                    <span>Ставка от 5% и гибкие условия.</span>
                                </li>
                                <li>
                                    <img src="<?php echo esc_url(frame_asset('img/icons/doc.svg')); ?>" alt="">
                                    <span>Перевод на счет под рекламные цели.</span>
                                </li>
                                <li>
                                    <img src="<?php echo esc_url(frame_asset('img/icons/doc.svg')); ?>" alt="">
                                    <span>Для арбитражных команд от 6 месяцев на рынке и с оборотом от $3 в
                                        месяц.</span>
                                </li>
                            </ol>
                        </div>
                        <?php get_template_part('template-parts/form') ?>
                    </div>
                </div>
                <div class="calc-item calc-item__deposit " data-tab-content="2">
                    <div class="grid grid-2">
                        <div class="calc-item__content">
                            <div class="calc-func">
                                <h4>Параметры вклада</h4>
                                <div class="input-range">
                                    <p>Cумма вклада</p>
                                    <div class="input-range__output">
                                        <div class="current-value">
                                            <span>10 000 </span> USD
                                        </div>
                                        <div class="max-value">
                                            до <span>300 000</span> USD
                                        </div>
                                    </div>
                                    <input type="range" name="deposit-value" min="10000" max="300000" value="100"
                                        step="100">
                                </div>

                                <div class="input-button">
                                    <p>Срок вклада</p>
                                    <div>
                                        <label for="deposit-period-3">
                                            3 мес
                                            <input type="radio" checked id="deposit-period-3" name="deposit-period"
                                                value="90 мес" data-percent="15">
                                        </label>
                                        <label for="deposit-period-6">
                                            6 мес
                                            <input type="radio" id="deposit-period-6" name="deposit-period"
                                                value="180 мес" data-percent="15.5">
                                        </label>
                                        <label for="deposit-period-12">
                                            12 мес
                                            <input type="radio" id="deposit-period-12" name="deposit-period"
                                                value="360 мес" data-percent="16">
                                        </label>
                                        <label for="deposit-period-18">
                                            18 мес
                                            <input type="radio" id="deposit-period-18" name="deposit-period"
                                                value="480 мес" data-percent="19">
                                        </label>
                                    </div>
                                </div>

                                <div class="calc-func__total">
                                    <div class="total-value">
                                        <div><label>105 000</label> USD</div>
                                        <span>Сумма к возврату</span>
                                        <input type="hidden" name="deposit-total" readonly value="105 000 USD">
                                    </div>
                                    <div class="total-percent">
                                        <div><label>19</label>%</div>
                                        <span>Процентная ставка</span>
                                        <input type="hidden" name="deposit-percents" readonly value="19%">
                                    </div>
                                </div>
                            </div>
                            <ol>
                                <li>
                                    <img src="<?php echo esc_url(frame_asset('img/icons/doc.svg')); ?>" alt="">
                                    <span>Максимальная ставка 19% в USDT.</span>
                                </li>
                                <li>
                                    <img src="<?php echo esc_url(frame_asset('img/icons/doc.svg')); ?>" alt="">
                                    <span>Полное или частичное изъятие онлайн. </span>
                                </li>
                                <li>
                                    <img src="<?php echo esc_url(frame_asset('img/icons/doc.svg')); ?>" alt="">
                                    <span>Ежемесячное начисление %</span>
                                </li>
                            </ol>
                        </div>
                        <?php get_template_part('template-parts/form') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>