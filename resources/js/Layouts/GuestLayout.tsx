import ApplicationLogo from '@/Components/ApplicationLogo';
import { Link } from '@inertiajs/react';
import "./../../css/Welcome.css"

import { PropsWithChildren } from 'react';
import {useStore} from "@/store";

export default function Guest({ children }: PropsWithChildren) {

    const {kz, invert} = useStore(state => state);

    return (
        <div className="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
            <div className="w-full bg-[#3b82f6] h-[56px] flex items-center justify-between">

                <div className="dancing-script-for-logo text-[34px] ml-[20px] text-white font-serif">namb.shop</div>


                <div className="flex mr-[50px]">
                    <button onClick={invert} className="w-4 h-4 mr-[20px] text-white text-lg">{kz ? "ru" : "kz"}</button>
                    <div>
                        <button className="px-6 py-1 bg-white  text-black font-semibold rounded-lg shadow-md hover:bg-[#bdbdbd] focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75 transition duration-300 ease-in-out">
                            {kz ? "Тіркелу" : "Зарегистрироваться"}
                        </button>
                    </div>
                </div>
            </div>


            <div>
                {children}
            </div>
        </div>
    );
}
