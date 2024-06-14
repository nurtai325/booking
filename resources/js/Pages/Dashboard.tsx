import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import {PageProps, Event, Reservation} from '@/types';
import {useEffect, useState} from "react";
import TimeTable from "@/Components/Dashboard/TimeTable";
import {useStore} from "@/store";
import axios from "axios";

export default function Dashboard({ auth }: PageProps) {
    const kz = useStore((state) => state.kz);
    const [loaded, setLoaded] = useState(false);
    const [schedule, setSchedule ] = useState([]);

    let user_id = auth.user.id;

    useEffect(() => {
        axios.get(`http://localhost:/api/schedule?id=${user_id}`)
            .then((response) => {
                 setSchedule(response.data.data);
                 setLoaded(true);
            })
            .catch((error) => console.log(error.message));
    }, []);

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 dark:text-black leading-tight">{kz ? " Кесте" : "Расписание"}</h2>}
        >
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="w-auto mx-auto sm:px-6 lg:px-8">
                    <div className="dark:bg-none overflow-hidden shadow-sm sm:rounded-lg flex">
                        {loaded ? <TimeTable schedule={schedule}/> : <div>{kz ? " Кесте туралы ақпарат жүктелуде..." : "Данные расписания загружаются..."}</div>}
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
