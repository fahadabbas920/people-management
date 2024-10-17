import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";
import People from "./People"; // Adjust the import path if necessary
import { useEffect, useState } from "react";
import AddPersonModal from "../Components/AddPersonModal"; // Import the modal component
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';


export default function Dashboard() {
    const [people, setPeople] = useState([]);
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [editPerson, setEditPerson] = useState(null);
    const [refetchData,setRefetchData] = useState(false);

    useEffect(() => {
        fetchPeople();
    }, [refetchData]);

    const fetchPeople = () => {
        fetch("/api/people")
            .then(response => {
                // if (!response.ok) {
                //     throw new Error('Network response was not ok');
                // }
                return response.json();
            })
            .then(data => {
                setPeople(data);

            })
            .catch(error => {
                toast.error(error?.response?.data?.message || "Something went wrong")
            });
    };

    const handleAddPerson = (newPerson) => {
        fetch("/api/people", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-Token": getCsrfToken(),
            },
            body: JSON.stringify(newPerson),
        })
        .then(response => {
            return response.json();
        })
        .then(data => {
            setRefetchData(state=>!state)
            toast.success("Added succesfully")
        })
        .catch(error => {
           toast.error("Error adding person");
        });
    };

    const handleUpdate = (id, formData) => {
        fetch(`/api/people/${id}`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-Token": getCsrfToken(), // Ensure you have a function for this
            },
            body: JSON.stringify(formData),
        })
        .then(response => {
            return response.json();
        })
        .then(data => {
            setRefetchData(state=>!state)
            setEditPerson(null);
            toast.success("updated succesfully")

        })
        .catch(error => {
           toast.error("Error updating person");
        });
    };

    const handleDelete = (id) => {
        if (confirm("Are you sure you want to delete this person?")) {
            fetch(`/api/people/${id}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-Token": getCsrfToken(),
                },
            })
            .then(response => {
                setRefetchData(state=>!state)
            toast.success("Deleted succesfully")
            })
            .catch(error => {
                toast.error("Error deleting person");
            });
        }
    };

    const getCsrfToken = () => {
        const match = document.cookie.match(/XSRF-TOKEN=([^;]+)/);
        return match ? match[1] : "";
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
             <ToastContainer />
        </AuthenticatedLayout>
    );
}
