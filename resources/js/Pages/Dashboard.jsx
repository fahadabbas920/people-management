import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";
import People from "./People"; // Adjust the import path if necessary
import { useEffect, useState } from "react";
import { Inertia } from "@inertiajs/inertia";
import AddPersonModal from "../Components/AddPersonModal"; // Import the modal component

export default function Dashboard() {
    const [people, setPeople] = useState([]);
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [editPerson, setEditPerson] = useState(null);

    useEffect(() => {
        fetch("/api/people")
            .then((response) => response.json())
            .then((data) => {
                console.log(data);
                setPeople(data);
            })
            .catch((error) => console.error("Error fetching people:", error));
    }, []);

    const getCsrfToken = () => {
        const match = document.cookie.match(/XSRF-TOKEN=([^;]+)/);
        return match ? match[1] : "";
    };

    const handleAddPerson = (newPerson) => {
        Inertia.post("/api/people", newPerson, {
            onSuccess: () => {
                console.log("Person added successfully");
            },
            onError: (errors) => {
                console.error(errors);
            },
        });
        window.location.reload();
    };

    const handleUpdate = (id, formData) => {
        console.log(id, formData);
        Inertia.put(`/api/people/${id}`, formData, {
            onSuccess: () => {
                console.log("Person updated:", id);
            },
            onError: (errors) => {
                console.error("Error updating person:", errors);
            },
        });
        setEditPerson(null);
        window.location.reload();
    };
    const handleDelete = (id) => {
        if (confirm("Are you sure you want to delete this person?")) {
            Inertia.delete(`/api/people/${id}`, {
                onSuccess: () => {
                    console.log("Person deleted:", id);
                },
                onError: (errors) => {
                    console.error("Error deleting person:", errors);
                },
            });
        }
        window.location.reload();
    };

    return (
        <AuthenticatedLayout
            header={
                <div className="flex justify-between items-center">
                    <h2 className="text-xl font-semibold leading-tight text-gray-800">
                        People Management
                    </h2>
                    <button
                        className="bg-blue-500 text-white p-2 rounded"
                        onClick={() => {
                            setIsModalOpen(true);
                            setEditPerson(null);
                        }}
                    >
                        Add Person
                    </button>
                </div>
            }
        >
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg p-4">
                        {/* <div className="p-6 text-gray-900">
                            You're logged in!
                        </div> */}
                        <People
                            setEditPerson={setEditPerson}
                            people={people}
                            onDelete={handleDelete}
                            setIsModalOpen={setIsModalOpen}
                        />
                    </div>
                </div>
            </div>

            <AddPersonModal
                editPerson={editPerson}
                isOpen={isModalOpen}
                onClose={() => setIsModalOpen(false)}
                onAdd={handleAddPerson}
                onEdit={handleUpdate}
                // setIsModalOpen={setIsModalOpen}
            />
        </AuthenticatedLayout>
    );
}
