import {ServiceDetail} from "@/types";
import {useStore} from "@/store";

interface props {
    schedule: ServiceDetail[],
    currentServiceName: any
}

export default function TimeTable({schedule, currentServiceName}: props) {
    const kz = useStore((state) => state.kz);

    return (
        <table className="min-w-full whitespace-nowrap border-collapse">
            <thead>
            <tr>
                <th className="border-b-2 border-gray-300 py-4 px-4  bg-[#6c7ae0]">{kz ? 'Уақыт' : 'Время'}</th>
                {/*<th className="border-b-2 border-gray-300 py-2 px-4 text-left bg-gray-200 ">{kz ? 'Кімге тіркелген' : 'Кому прописан'}</th>*/}
                {schedule.length === 0 && schedule.map((service) =>
                    <th>service.name</th>
                )}
                <th className="border-b-2 border-gray-300 py-4 px-4 text-left bg-[#6c7ae0]">{kz ? 'Ұзақтығы' : 'Длительность'}</th>
                <th className="border-b-2 border-gray-300 py-4 px-4 text-left bg-[#6c7ae0]">{kz ? 'Бағасы' : 'Цена'}</th>
                <th className="border-b-2 border-gray-300 py-4 px-4 text-left bg-[#6c7ae0]">{kz ? 'Қатысушылар' : 'Участники'}</th>

            </tr>

            </thead>


            {schedule.length > 0 ? (
                schedule.map((serviceItem, serviceIndex) => {
                    if (currentServiceName === serviceItem.service.name){
                    return (

                    serviceItem.bookings.map((bookingItem, bookingIndex) => (
                        <tbody key={`${serviceIndex}-${bookingIndex}`}>
                        <tr className="mt-20">

                            <td className="border-b-2 border-gray-300 py-2 px-4 text-left bg-gray-200">{bookingItem.booking.start_time}</td>
                            <td className="border-b-2 border-gray-300 py-2 px-4 text-left bg-gray-200">{serviceItem.service.duration}</td>
                            <td className="border-b-2 border-gray-300 py-2 px-4 text-left bg-gray-200">{serviceItem.service.price}</td>
                            <td className="border-b-2 border-gray-300 py-2 px-4 text-left bg-gray-200">
                                <ul>
                                    {bookingItem.records.map((record, recordIndex) => (
                                        <li key={record.record_id}>
                                            {record.name} : {record.phone}
                                        </li>
                                    ))}
                                </ul>
                            </td>

                            {/*  <td>
                        <div className="flex flex-col justify-center">
                        <button className="w-[80px] rounded-full h-[25px] bg-red-600 mb-4 ml-3">Delete</button>
                        <button className="w-[80px] rounded-full h-[25px] bg-green-600 ml-3">Edit</button>

                        </div>
                    </td>*/}
                        </tr>
                        </tbody>

                    ))

                    )} else {
                        return null;
                    }
                }
            )) : (
                <tr>
                    <td className="border-b-2 border-gray-300 py-2 px-4 text-left bg-gray-200">No schedules available</td>
                </tr>
            )}
        </table>
    )
}
