import React, { useState, useEffect } from "react";

const initialValue = {
    name: "",
    surname: "",
    south_african_id_number: "",
    mobile_number: "",
    email: "",
    date_of_birth: "",
    language: "",
    interests: [],
};

const AddPersonModal = ({
    isOpen,
    onClose,
    onAdd,
    editPerson: person,
    onEdit,
}) => {
    const [formData, setFormData] = useState(initialValue);
    const [errors, setErrors] = useState({});
    console.log(formData);

    useEffect(() => {
        if (!!person) {
            setFormData({
                name: person.name || "",
                surname: person.surname || "",
                south_african_id_number: person.south_african_id_number || "",
                mobile_number: person.mobile_number || "",
                email: person.email || "",
                date_of_birth: person.date_of_birth || "",
                language: person.language || "",
                interests: person.interests || [],
            });
        }
        return () => {
            setFormData(initialValue);
            setErrors({});
        };
    }, [person]);

    // Validate form data
    const validateForm = () => {
        const newErrors = {};

        if (!formData.name || formData.name.length > 20) {
            newErrors.name =
                "Name is required and should not exceed 20 characters.";
        }
        if (!formData.surname || formData.surname.length > 20) {
            newErrors.surname =
                "Surname is required and should not exceed 20 characters.";
        }
        if (
            !formData.south_african_id_number ||
            !/^\d{13}$/.test(formData.south_african_id_number)
        ) {
            newErrors.south_african_id_number =
                "Valid South African ID Number (13 digits) is required.";
        }
        if (
            !formData.mobile_number ||
            !/^\d{1,13}$/.test(formData.mobile_number)
        ) {
            newErrors.mobile_number =
                "Valid Mobile Number (up to 13 digits) is required.";
        }
        if (!formData.email || !/^\S+@\S+\.\S+$/.test(formData.email)) {
            newErrors.email = "A valid email address is required.";
        }
        if (!formData.date_of_birth) {
            newErrors.date_of_birth = "Date of Birth is required.";
        }
        if (!formData.language || formData.language.length > 13) {
            newErrors.language = "Language should not exceed 13 characters.";
        }

        return newErrors;
    };

    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData({ ...formData, [name]: value });
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        const validationErrors = validateForm();

        if (Object.keys(validationErrors).length === 0) {
            if (!!person) {
                onEdit(person?.id, formData);
            } else {
                onAdd(formData);
            }
            onClose();
        } else {
            setErrors(validationErrors); // Set the errors state if validation fails
        }
    };

    if (!isOpen) return null;

    const handleCheckboxChange = (e) => {
        const { value, checked } = e.target;
        setFormData((prevData) => {
            const updatedInterests = checked
                ? [...prevData.interests, value]
                : prevData.interests.filter((interest) => interest !== value);
            return { ...prevData, interests: updatedInterests };
        });
    };

    return (
        <div className="fixed inset-0 flex items-center justify-center z-50">
            <div
                className="fixed inset-0 bg-black opacity-50"
                onClick={onClose}
            />
            <div
                className="bg-white p-6 rounded-lg shadow-lg z-10"
                style={{ width: "500px" }}
            >
                <h2 className="text-xl mb-4">
                    {person ? "Edit Person" : "Add Person"}
                </h2>
                <form
                    onSubmit={handleSubmit}
                    className="grid grid-cols-2 gap-6 overflow-y-auto"
                >
                    {/* Name */}
                    <div className="col-span-1">
                        <label className="block font-medium text-gray-700">
                            Name
                        </label>
                        <input
                            type="text"
                            name="name"
                            value={formData.name}
                            onChange={handleChange}
                            className={`mt-1 block w-48 rounded-md border-gray-300 shadow-sm ${
                                errors.name && "border-red-500"
                            }`}
                            required
                        />
                        {errors.name && (
                            <p className="text-red-500">{errors.name}</p>
                        )}
                    </div>
                    {/* Surname */}
                    <div className="col-span-1">
                        <label className="block font-medium text-gray-700">
                            Surname
                        </label>
                        <input
                            type="text"
                            name="surname"
                            value={formData.surname}
                            onChange={handleChange}
                            className={`mt-1 block w-48 rounded-md border-gray-300 shadow-sm ${
                                errors.surname && "border-red-500"
                            }`}
                            required
                        />
                        {errors.surname && (
                            <p className="text-red-500">{errors.surname}</p>
                        )}
                    </div>
                    {/* South African ID Number */}
                    <div className="col-span-1">
                        <label className="block font-medium text-gray-700">
                            South African ID Number
                        </label>
                        <input
                            type="text"
                            name="south_african_id_number"
                            value={formData.south_african_id_number}
                            onChange={handleChange}
                            className={`mt-1 block w-48 rounded-md border-gray-300 shadow-sm ${
                                errors.south_african_id_number &&
                                "border-red-500"
                            }`}
                            required
                        />
                        {errors.south_african_id_number && (
                            <p className="text-red-500">
                                {errors.south_african_id_number}
                            </p>
                        )}
                    </div>
                    {/* Mobile Number */}
                    <div className="col-span-1">
                        <label className="block font-medium text-gray-700">
                            Mobile Number
                        </label>
                        <input
                            type="text"
                            name="mobile_number"
                            value={formData.mobile_number}
                            onChange={handleChange}
                            className={`mt-1 block w-48 rounded-md border-gray-300 shadow-sm ${
                                errors.mobile_number && "border-red-500"
                            }`}
                            required
                        />
                        {errors.mobile_number && (
                            <p className="text-red-500">
                                {errors.mobile_number}
                            </p>
                        )}
                    </div>
                    {/* Email */}
                    <div className="col-span-1">
                        <label className="block font-medium text-gray-700">
                            Email
                        </label>
                        <input
                            type="email"
                            name="email"
                            value={formData.email}
                            onChange={handleChange}
                            className={`mt-1 block w-48 rounded-md border-gray-300 shadow-sm ${
                                errors.email && "border-red-500"
                            }`}
                            required
                        />
                        {errors.email && (
                            <p className="text-red-500">{errors.email}</p>
                        )}
                    </div>
                    {/* Date of Birth */}
                    <div className="col-span-1">
                        <label className="block font-medium text-gray-700">
                            Date of Birth
                        </label>
                        <input
                            type="date"
                            name="date_of_birth"
                            value={formData.date_of_birth}
                            onChange={handleChange}
                            className={`mt-1 block w-48 rounded-md border-gray-300 shadow-sm ${
                                errors.date_of_birth && "border-red-500"
                            }`}
                            required
                        />
                        {errors.date_of_birth && (
                            <p className="text-red-500">
                                {errors.date_of_birth}
                            </p>
                        )}
                    </div>
                    {/* Language */}
                    <div className="col-span-1">
                        <label className="block font-medium text-gray-700">
                            Language
                        </label>
                        <input
                            type="text"
                            name="language"
                            value={formData.language}
                            onChange={handleChange}
                            className={`mt-1 block w-48 rounded-md border-gray-300 shadow-sm ${
                                errors.language && "border-red-500"
                            }`}
                            required
                        />
                        {errors.language && (
                            <p className="text-red-500">{errors.language}</p>
                        )}
                    </div>
                    {/* Interests (Checkboxes) */}
                    <div className="col-span-2">
                        <label className="block font-medium text-gray-700">
                            Interests
                        </label>
                        <div className="flex flex-col">
                            {["Interest1", "Interest2", "Interest3"].map(
                                (interest) => (
                                    <label
                                        key={interest}
                                        className="flex items-center"
                                    >
                                        <input
                                            type="checkbox"
                                            value={interest}
                                            checked={formData.interests.includes(
                                                interest
                                            )}
                                            onChange={handleCheckboxChange}
                                            className="mr-2"
                                        />
                                        {interest}
                                    </label>
                                )
                            )}
                        </div>
                    </div>
                    <div className="col-span-2 mt-0 flex justify-end">
                        <button
                            type="submit"
                            className="bg-blue-500 text-white px-4 py-0 rounded"
                        >
                            {person ? "Edit Person" : "Add Person"}
                        </button>
                        <button
                            onClick={() => {
                                onClose();
                                setErrors({});
                                setFormData(initialValue)
                                
                            }}
                            type="button"
                            className="ml-4 text-red-500"
                        >
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    );
};

export default AddPersonModal;
