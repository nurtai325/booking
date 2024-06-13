import {ServiceDetail} from "@/types";
import {useStore} from "@/store";

interface props {
    schedule: ServiceDetail[]
}

export default function TimeTable({schedule}: props) {
    const kz = useStore((state) => state.kz);

    return (
        <table className="min-w-full border-collapse">
            <thead>
            <tr>
                <th className="border-b-2 border-gray-300 py-2 px-4 text-left bg-gray-200">{kz ? 'Уақыт' : 'Время'}</th>
                {schedule.length === 0 && schedule.map((service) =>
                    <th>service.name</th>
                )}
            </tr>
            </thead>
            <tbody>
                {schedule.length === 0 && schedule.map((service) =>
                    <tr>
                        <td>

                        </td>
                    </tr>
                )}

            </tbody>
        </table>
    )
}
