import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import { PageProps } from '@/types';
import {useEffect, useState} from "react";
import axios, {AxiosResponse} from "axios";

export default function Dashboard({ auth }: PageProps) {
    const [data, setData] = useState('empty');

    useEffect(function () {
        axios.get('http://localhost:8000/api/service/getAll?id=1')
            .then(function (result) {
                setData(result.data.data);
                console.log(result.data.data);
            })
            .catch(function (error) {
                console.log(error.message);
            })

    }, []);

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>}
        >
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-black dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900 dark:text-gray-300">You're logged in!</div>
                        <div className="p-6 text-gray-900 dark:text-gray-300">{data.toString()}</div>

                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
