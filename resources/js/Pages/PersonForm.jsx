import React, { useEffect, useState } from 'react';
import { Inertia } from '@inertiajs/inertia';
import { useParams } from 'react-router-dom';

const PersonForm = ({ person }) => {
    const [formData, setFormData] = useState({
        name: '',
        surname: '',
        south_african_id_number: '',
        mobile_number: '',
        email: '',
        date_of_birth: '',
        language: '',
        interests: []
    });
    const interestsOptions = ['Reading', 'Sports', 'Travelling', 'Music'];
    const { id } = useParams();

    useEffect(() => {
        if (person) {
            setFormData(person); // Populate form with existing data
        }
    }, [person]);

    const handleChange = (e) => {
        const { name, value, type, checked } = e.target;
        setFormData(prev => ({
            ...prev,
            [name]: type === 'checkbox' ? (checked ? [...prev.interests, value] : prev.interests.filter(i => i !== value)) : value
        }));
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        const url = id ? `/people/${id}` : '/people';
        const method = id ? 'PUT' : 'POST';

        Inertia[method.toLowerCase()](url, formData); // Use Inertia to submit the form
    };

    return (
        <form onSubmit={handleSubmit} className="max-w-md mx-auto mt-10">
            <h2 className="text-xl font-semibold mb-4">{id ? 'Edit Person' : 'Add Person'}</h2>
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
            <select
                name="language"
                value={formData.language}
                onChange={handleChange}
                required
                className="w-full p-2 border border-gray-300 rounded mb-4"
            >
                <option value="">Select Language</option>
                <option value="English">English</option>
                <option value="Afrikaans">Afrikaans</option>
                {/* Add other languages as needed */}
            </select>

            <div className="mb-4">
                <h4>Interests:</h4>
                {interestsOptions.map((interest) => (
                    <label key={interest} className="inline-flex items-center">
                        <input
                            type="checkbox"
                            value={interest}
                            checked={formData.interests.includes(interest)}
                            onChange={handleChange}
                            className="mr-2"
                        />
                        {interest}
                    </label>
                ))}
            </div>

            <button type="submit" className="bg-blue-500 text-white px-4 py-2 rounded">
                {id ? 'Update Person' : 'Add Person'}
            </button>
        </form>
    );
};

export default PersonForm;
