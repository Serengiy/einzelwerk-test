import {useState} from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import {Head, useForm} from "@inertiajs/react";

export default function Dashboard({ contragents }) {
    const [showModal, setShowModal] = useState(false);

    const { data, setData, post, processing, errors, reset } = useForm({
        inn: "",
    });
    const [queryString, setQueryString] = useState("");
    const [error, setError] = useState('');


    const handleSubmit = (e) => {
        e.preventDefault();
        post("/contragents", {
            preserveScroll: true,
            onSuccess: () => {
                setShowModal(false);
                reset();
            }, onError: (errors) => {
                setError(errors.message);
            }
        });
    };
    const handleSearchChange = (e) => {
        setQueryString(e.target.value);
    };

    return (
        <AuthenticatedLayout
            header={
                <div className="flex justify-between items-center">
                    <h2 className="text-xl font-semibold leading-tight text-gray-800">
                        Добавленные контрагенты
                    </h2>
                    <button
                        onClick={() => setShowModal(true)}
                        className="px-2 py-1 bg-orange-600 text-sm text-white rounded-md hover:bg-red-600"
                    >
                        Добавить
                    </button>
                </div>
            }
        >
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6 text-gray-900">
                        {/*<div className="flex space-x-4 mb-4">*/}
                        {/*    <input*/}
                        {/*        type="text"*/}
                        {/*        placeholder="Поиск по ИНН / наименованию"*/}
                        {/*        value={queryString}*/}
                        {/*        onChange={handleSearchChange}*/}
                        {/*        className="p-2 border rounded w-full"*/}
                        {/*    />*/}
                        {/*</div>*/}
                        {contragents?.data.length > 0 ? (
                            <>
                                <table className="w-full border-collapse border border-gray-300">
                                    <thead>
                                    <tr className="bg-gray-100">
                                        <th className="border p-2">ИНН</th>
                                        <th className="border p-2">Наименование</th>
                                        <th className="border p-2">ОГРН</th>
                                        <th className="border p-2">Адрес</th>
                                    </tr>
                                    </thead>
                                    <tbody className='text-sm'>
                                    {contragents?.data.map((contragent) => (
                                        <tr key={contragent.id} className="border">
                                            <td className="border p-2">{contragent.inn}</td>
                                            <td className="border p-2">{contragent.name}</td>
                                            <td className="border p-2">{contragent.ogrn}</td>
                                            <td className="border p-2">{contragent.address}</td>
                                        </tr>
                                    ))}
                                    </tbody>
                                </table>

                                <div className="mt-4">
                                    {contragents?.meta.links.map((link, index) => (
                                        <a
                                            key={index}
                                            href={link.url || "#"}
                                            className={`px-3 py-1 mx-1 border rounded ${
                                                link.active
                                                    ? "bg-orange-600 text-white"
                                                    : "bg-gray-200 text-gray-700"
                                            }`}
                                            dangerouslySetInnerHTML={{__html: link.label}}
                                        />
                                    ))}
                                </div>
                            </>
                        ) : (
                            <div className="flex flex-col items-center justify-center h-64">
                                <p className="text-lg mb-2">
                                    Контрагенты еще не добавлены.
                                </p>
                                <p className={'text-gray-600 mb-2'}>
                                    Добавьте первого агента.
                                </p>
                                <button
                                    onClick={() => setShowModal(true)}
                                    className="px-2 py-1 bg-orange-600 text-sm text-white rounded-md hover:bg-red-600"
                                >
                                    Добавить
                                </button>
                            </div>
                        )}
                    </div>
                </div>
            </div>

            {showModal && (
                <div className="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
                    <div className="bg-white p-6 rounded-md shadow-md w-2/5">
                        <h3 className="text-lg font-semibold">Добавить контрагента</h3>
                        <p className="text-xs text-gray-600 mb-3">Введите ИНН, чтобы добавить контрагента</p>
                        <form onSubmit={handleSubmit}>
                            <input
                                type="text"
                                value={data.inn}
                                onChange={(e) => setData("inn", e.target.value)}
                                placeholder="Введите ИНН"
                                className="w-full p-2 border rounded mb-2"
                            />
                            {errors.inn && (
                                <p className="text-red-600 text-sm mb-3">{errors.inn}</p>
                            )}
                            {error && (
                                <p className="text-red-600 text-sm mb-3">{error}</p>
                            )}
                            <p className="text-xs text-gray-600 mb-3">
                                После нажатия кнопки "Добавить", данные автоматически подгрузятся в таблицу.
                            </p>
                            <div className="flex justify-end">
                                <button
                                    type="button"
                                    onClick={() => setShowModal(false)}
                                    className="px-2 py-1 bg-gray-600 mr-4 text-sm text-white rounded-md hover:bg-red-600"
                                >
                                    Отмена
                                </button>
                                <button
                                    type="submit"
                                    disabled={processing}
                                    className={`px-2 py-1 text-sm text-white rounded-md ${
                                        processing
                                            ? "bg-gray-400 cursor-not-allowed"
                                            : "bg-orange-600 hover:bg-red-600"
                                    }`}
                                >
                                    {processing ? "Добавление..." : "Добавить"}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            )}
        </AuthenticatedLayout>
    );
}
