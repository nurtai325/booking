import { Link, Head } from '@inertiajs/react';
import { PageProps } from '@/types';
import {useStore} from "@/store";
import {useState} from "react";
import "./../../css/Welcome.css"
import Guest from "@/Layouts/GuestLayout";




export default function Welcome() {

    const kz = useStore((state) => state.kz);


    return (
        <Guest>

        <div className="min-h-screen ">
            <Head title="Welcome" />

            <div className="w-full h-">

            </div>


            <div className="flex flex-col items-center justify-center bg-gray-100 text-gray-800 text-center p-5">
                <h1 className="mb-[30px] mt-[50px] text-[3.3em] text-[black] font-serif">
                    {kz ? " Жасанды интеллектпен қуатталған броньдау жүйесі!" : "Система бронирования с искусственным интеллектом"}
                </h1>

                {/*<p>Ваше универсальное решение для эффективного управления бронированиями.</p>*/}

                <div className="feature-area">
                    <div className="feature-area-card">
                        <div className="feature-area-card__text text-left card-item">
                            <h2 className="feature-area-card__header mb-[40px] text-[24px] text-[#469fff] font-semibold">
                                {kz ? " Броньдауды тиімді басқаруға арналған универсалды шешімі." : "Ваше универсальное решение для эффективного управления бронированиями.\n"}
                            </h2>


                            <div className="feature-area-card__description text-left">
                                {kz ?
                                "Біздің ыңғайлы бақылау тақтасы барлық брондауды басқару үшін интуитивті интерфейсті қамтамасыз етеді.\n" +
                                    "Сіз маңызды ақпаратқа тез қол жеткізе аласыз және қажетсіз күш жұмсамай-ақ қажетті әрекеттерді жасай аласыз.\n" +
                                    "Барлық ақпарат құрылымдалған және бірнеше рет басу арқылы қол жетімді, бұл сізге\n" +
                                    "маңызды міндеттерге назар аударыңыз." :
                                    "Наш удобный дашборд обеспечивает интуитивно понятный интерфейс для управления всеми вашими бронированиями.\n" +
                                    "Вы можете быстро получить доступ к важной информации и выполнять необходимые действия без лишних усилий.\n" +
                                    "Вся информация структурирована и доступна в несколько кликов, что позволяет вам\n" +
                                    "сосредоточиться на важных задачах."
                                }
{/*                                <button
                                    className="custom-btn tooltip-container btn-2 w-[200px] h-[33px] rounded-[10px] text-center bg-[#469fff] hover:bg-[#025bbd] text-white mt-[20px]">
                                    <span className="text">
                                    {kz ? "Жұмысты бастау" : "Начать"}
                                    </span>
                                </button>*/}

                                <div className=" mt-[15px] font-semibold ">

                                <div>
                                    {kz ? "Біздің сату бөліміне хабарласыңыз: ": "Свяжитесь с нашим отделом продаж"}
                                </div>
                                <div>
                                    +7 747 625 8173 <br/>
                                    +7 747 547 2426
                                </div>
                                </div>
                            </div>
                        </div>


                        <div className="feature-area-card__content card-item">
                            <video className="feature-area-card__video" autoPlay muted loop playsInline>
                                <source
                                    src="/Videos/01.mp4"
                                    type="video/mp4"/>
                            </video>

                        </div>
                    </div>
                </div>





                <div className="feature-area">

                    <div className="feature-area-card">
                        <div className="feature-area-card__content card-item">
                            <video className="feature-area-card__video" autoPlay muted loop playsInline>
                                <source
                                    src="/Videos/02.webm"
                                    type="video/webm"/>
                                <source
                                    src="/Videos/02.mp4"
                                    type="video/mp4"/>
                            </video>

                        </div>


                        <div className="feature-area-card__text text-left card-item">

                            <h2 className="feature-area-card__header mb-[40px] text-[24px] text-[#469fff] font-semibold">
                                {kz ? " Пайдалану оңай Басқару тақтасы." : "Простая в использовании панель управления.\n"}


                            </h2>

                            <div className="feature-area-card__description text-left">
                                {kz ?
                                    "Нақты уақыттағы жаңартулардың арқасында барлық өзгерістерден хабардар болыңыз.\n" +
                                    "Сіз жаңа брондау, бас тарту немесе өзгерту алсаңыз да, сізге бірден хабарланады.\n" +
                                    "Бұл өзгерістерге жедел жауап беруге және тұтынушыларға қызмет көрсетудің жоғары деңгейін сақтауға мүмкіндік береді."
                                    + "" : "" +
                                    "Будьте в курсе всех изменений благодаря обновлениям в режиме реального времени.\n" +
                                    "Независимо от того, получаете ли вы новое бронирование, отмену или изменение, вы будете уведомлены мгновенно.\n" +
                                    "Это позволяет оперативно реагировать на изменения и поддерживать высокий уровень обслуживания ваших клиентов."}




                            </div>

                        </div>


                    </div>
                </div>


                <div className="flex flex-wrap justify-center gap-[40px] mb-[40px] w-[90%]">


                    <div className="feature-area-card">
                        <div className="feature-area-card__text card-item">
                            <h2 className="feature-area-card__header mb-[40px] text-[24px] text-[#469fff] font-semibold text-left">
                                {kz ? "Нақты уақыттағы жаңартулар" : "Обновления в режиме реального времени" }

                            </h2>
                            <div className="feature-area-card__description text-left">
                                {kz ?
                                    "Біздің ыңғайлы бақылау тақтасы барлық брондауды басқаруға арналған интуитивті интерфейсті ұсынады.\n" +
                                    "Маңызды ақпаратқа жылдам қол жеткізу және қарапайым әрекеттерді орындау.\n" +
                                    "Сіз барлық процестерді оңай қадағалай аласыз және сұраныстарға уақтылы жауап бере аласыз, бұл сіздің клиенттеріңіздің сенімі мен адалдығын арттырады." : "Наша удобная панель мониторинга предоставляет интуитивно понятный интерфейс для управления всеми вашими бронированиями.\n" +
                                    "Быстрый доступ к важной информации и простое выполнение действий.\n" +
                                    "Вы сможете легко отслеживать все процессы и своевременно реагировать на запросы, что способствует повышению доверия и лояльности ваших клиентов."}

                            </div>
                        </div>


                        <div className="feature-area-card__content card-item">
                            <video className="feature-area-card__video" autoPlay muted loop playsInline>
                                <source
                                    src="/Videos/04.webm"
                                    type="video/webm"/>
                                <source
                                    src="/Videos/04.mp4"
                                    type="video/mp4"/>
                            </video>
                        </div>
                    </div>


                {/*    <div className="benefit-block">
                        <h2>Простая в использовании панель управления</h2>
                        <div className="text-[18px] text-left w-[80%] ml-9">
                            Наша удобная панель мониторинга предоставляет интуитивно понятный интерфейс для управления
                            всеми вашими бронированиями.
                            Быстрый доступ к важной информации и простое выполнение действий.
                        </div>
                        <div>
                            <button
                                className="bg-[#007bff] w-[100px] text-[20px] rounded-full h-[35px] hover:bg-[#025bbd] text-white  active:text-[18px]">Начать
                            </button>
                        </div>
                    </div>


                    <div className="benefit-block">
                        <h2>Обновления в режиме реального времени</h2>
                        <p>
                            Будьте в курсе всех изменений благодаря обновлениям в режиме реального времени.
                            Независимо от того, получаете ли вы новое бронирование, отмену или изменение, вы будете
                            уведомлены мгновенно.
                            Это позволяет оперативно реагировать на изменения и поддерживать высокий уровень
                            обслуживания ваших клиентов.
                        </p>
                    </div>


                    <div className="benefit-block">
                        <h2>Комплексная аналитика</h2>
                        <p>
                            Получите представление о тенденциях вашего бронирования с помощью наших комплексных
                            инструментов аналитики. Отслеживайте свой
                            производительность, выявлять закономерности и принимать решения, основанные на данных.
                        </p>
                    </div>*/}

                </div>


            </div>
        </div>

        </Guest>
    );
}
