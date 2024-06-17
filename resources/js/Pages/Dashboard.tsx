import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import {PageProps, Event, Reservation, ServiceDetail} from '@/types';
import {useEffect, useState, useMemo} from "react";
import TimeTable from "@/Components/Dashboard/TimeTable";
import {useStore} from "@/store";
import axios from "axios";
import "./../../css/Dashboard.css"
import '@fortawesome/fontawesome-free/css/all.css';

import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import { faChevronDown } from '@fortawesome/free-solid-svg-icons';

export default function Dashboard({ auth }: PageProps) {


    const kz = useStore((state) => state.kz);
    const [loaded, setLoaded] = useState(false);
    const [schedule, setSchedule ] = useState<ServiceDetail[]>([]);

    const [currentService, setCurrentService] = useState(0)
    const [currentServiceName, setCurrentServiceName] = useState<string>('');
    // const [currentServiceName, setCurrentServiceName] = useState<any>(schedule.map((item, indexItem) => {if (indexItem === currentService) {return item.service.name}} ));

    const [isOpen, setIsOpen] = useState(false);

    const [windowWidth, setWindowWidth] = useState(window.innerWidth)
    const toggleClass = () => {
        setIsOpen(!isOpen);
    };

    let user_id = auth.user.id;

    useEffect(() => {
        const handleResize = () => {
            setWindowWidth(window.innerWidth); // Update state when window is resized
        };

        window.addEventListener('resize', handleResize);

        return () => {
            window.removeEventListener('resize', handleResize);
        };
    }, []);

    useEffect(() => {
        const fetchSchedule = () => {
        axios.get(`http://localhost:/api/schedule?id=${user_id}`)
            .then((response) => {
                setSchedule(response.data.data);
                setLoaded(true);
                console.log("15 seconds left")
            })
            .catch((error) => console.log(error.message));
        }
        fetchSchedule();

        const fetchScheduleTimer = setInterval(fetchSchedule, 15000)

        return () => clearInterval(fetchScheduleTimer);

    }, [user_id]);

    useEffect(() => {
        if (schedule.length > 0) {
            setCurrentServiceName(schedule[currentService].service.name);
        }
    }, [schedule, currentService]);


    const InfoIcon = useMemo(() => {
        return <div className="absolute">&#128712; &#9432;  </div>;
    }, []);

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 dark:text-black leading-tight">{kz ? " Кесте" : "Расписание"}</h2>}
        >

            <Head title="Dashboard" />

            <div className="py-12">
                <div className="w-auto mx-auto sm:px-6 lg:px-8">


                    <nav className="bg-gray-500 rounded-full mb-[40px] z-2 h-[70px] max-h-[70px]">
                        <div className="flex items-center p-2 z-2 relative">
                            <div className="text-white text-lg ml-[20px] z-2 absolute font-semibold top-[20px]">{kz ? "Сервистер" : "Cервисы"}</div>

                            {windowWidth > 1000 ?
                                <div className="w-full rounded-full z-2 rounded-br-[0]">
                                    <ul className="flex ml-[120px] mt-[10px] z-2 w-[auto] scrollbar-cus scrollbar overflow-x-auto scrollbar-thumb-blue-600 ">
                                        <li className="w-[1px]"></li>
                                        {schedule.map((serviceItem, serviceIndex) => (
                                                <li key={serviceIndex} onClick={() => {
                                                    setCurrentService(serviceIndex)
                                                }}
                                                    className={`p-1 ml-2 relative cursor-pointer flex justify-center rounded-full  ${serviceIndex === currentService ? 'bg-gray-300 text-black' : 'bg-gray-500 text-white'} h-full block`}
                                                >
                                                    <a href="#" className="whitespace-nowrap">
                                                        {serviceItem.service.name}
                                                    </a>
                                                    {/*<div className="absolute top-[1px] right-1" data-title={serviceItem.service.description}>&#128712;</div>*/}
                                                </li>
                                            )
                                        )}
                                        <li className="w-[1px] px-[6px]  p-1 ml-2 block  h-full"></li>

                                    </ul>
                                </div>

                                :

                                <div className="relative ml-[120px] top-1">
                                    <div className={isOpen ? 'select-btn open' : 'select-btn'} onClick={toggleClass}>
                                        <span className="btn-text">{currentServiceName}</span>
                                        <span className="arrow-dwn">
                                                {/*<i className="fa-solid fa-chevron-down"></i>*/}
                                            <FontAwesomeIcon icon={faChevronDown} />
                                      </span>
                                    </div>

                                    <ul className="list-items absolute">
                                        {schedule.map((serviceItem, serviceIndex) => (
                                                <li key={serviceIndex} onClick={() => {
                                                    setCurrentService(serviceIndex)
                                                }} className="item">
                                                    <span className="item-text">{serviceItem.service.name}</span>

                                                    {/*<div className="absolute top-[1px] right-1" data-title={serviceItem.service.description}>&#128712;</div>*/}
                                                </li>
                                            )
                                        )}
                                    </ul>
                                </div>
                            }

                        </div>
                    </nav>


                    <div className="dark:bg-none overflow-x-auto scrollbar scrollbar-cus scrollbar-thumb-blue-600 shadow-sm sm:rounded-lg flex">
                        {loaded ? <TimeTable schedule={schedule} currentServiceName={currentServiceName}/> :
                            <div>{kz ? " Кесте туралы ақпарат жүктелуде..." : "Данные расписания загружаются..."}</div>}
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
