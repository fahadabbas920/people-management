import React, { useEffect, useState } from "react";
import { Inertia } from "@inertiajs/inertia";
import { useParams } from "react-router-dom";

const PersonForm = ({ person }) => {
    const { id } = useParams();

    const [formData, setFormData] = useState({
        name: "",
        surname: "",
        south_african_id_number: "",
        mobile_number: "",
        email: "",
        date_of_birth: "",
        language: "",
        interests: "", // Change to string for comma-separated input
    });

    useEffect(() => {
        if (person) {
            setFormData(person); // Populate form with existing data
        }
    }, [person]);

    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData((prev) => ({
            ...prev,
            [name]: value, // Update formData for all inputs
        }));
    };

    const transformInterestsToArray = () => {
        // Transform the comma-separated string into an array
        const interestsArray = formData.interests
            .split(",")
            .map((interest) => interest.trim()) // Trim whitespace from each interest
            .filter((interest) => interest); // Remove empty strings

        return interestsArray;
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        const interestsArray = transformInterestsToArray(); // Get the transformed array

        // Prepare the data for submission
        const dataToSubmit = { ...formData, interests: interestsArray };

        const url = id ? `/people/${id}` : "/people";
        const method = id ? "PUT" : "POST";

        Inertia[method.toLowerCase()](url, dataToSubmit); // Use Inertia to submit the form
    };

    return (
        <form onSubmit={handleSubmit} className="max-w-md mx-auto mt-10">
            <h2 className="text-xl font-semibold mb-4">
                {id ? "Edit Person" : "Add Person"}
            </h2>
            <input
                type="text"
                name="name"
                placeholder="Name"
                value={formData.name}
                onChange={handleChange}
                required
                className="w-full p-2 border border-gray-300 rounded mb-4"
            />
            <input
                type="text"
                name="surname"
                placeholder="Surname"
                value={formData.surname}
                onChange={handleChange}
                required
                className="w-full p-2 border border-gray-300 rounded mb-4"
            />
            <input
                type="text"
                name="south_african_id_number"
                placeholder="South African ID Number"
                value={formData.south_african_id_number}
                onChange={handleChange}
                required
                className="w-full p-2 border border-gray-300 rounded mb-4"
            />
            <input
                type="text"
                name="mobile_number"
                placeholder="Mobile Number"
                value={formData.mobile_number}
                onChange={handleChange}
                required
                className="w-full p-2 border border-gray-300 rounded mb-4"
            />
            <input
                type="email"
                name="email"
                placeholder="Email"
                value={formData.email}
                onChange={handleChange}
                required
                className="w-full p-2 border border-gray-300 rounded mb-4"
            />
            <input
                type="date"
                name="date_of_birth"
                value={formData.date_of_birth}
                onChange={handleChange}
                required
                className="w-full p-2 border border-gray-300 rounded mb-4"
            />
            <input
                type="text"
                name="language"
                value={formData.language}
                onChange={handleChange}
                placeholder="Enter your preferred language"
                required
                className="w-full p-2 border border-gray-300 rounded mb-4"
            />

            <input
                type="text"
                name="interests"
                value={formData.interests}
                onChange={handleChange}
                placeholder="Enter your interests, separated by commas"
                className="w-full p-2 border border-gray-300 rounded mb-4"
            />

            <button
                type="submit"
                className="bg-blue-500 text-white px-4 py-2 rounded"
            >
                {id ? "Update Person" : "Add Person"}
            </button>
        </form>
    );
};

export default PersonForm;
