import React from "react";

const People = ({ people, onDelete, setEditPerson, setIsModalOpen }) => {
    console.log(people);
    return (
        <div className="mt-6">
            <h3 className="text-lg font-semibold text-gray-800">People List</h3>
            <div className="mt-4">
                {people?.length === 0 ? (
                    <p className="text-gray-500">No people found.</p>
                ) : (
                    <ul className="space-y-4">
                        {people?.map((person) => (
                            <li
                                key={person?.id}
                                className="p-4 border rounded-lg shadow flex justify-between items-center"
                            >
                                <div>
                                    <h4 className="font-bold">
                                        {person?.name}
                                    </h4>
                                    <p className="text-gray-600">
                                        {person?.email}
                                    </p>
                                </div>
                                <div className="space-x-2">
                                    <button
                                        onClick={() => {
                                            setIsModalOpen(true)
                                            setEditPerson(person)}}
                                        className="px-2 py-1 text-white bg-blue-500 rounded hover:bg-blue-600"
                                    >
                                        Edit
                                    </button>
                                    <button
                                        onClick={() => onDelete(person?.id)}
                                        className="px-2 py-1 text-white bg-red-500 rounded hover:bg-red-600"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </li>
                        ))}
                    </ul>
                )}
            </div>
        </div>
    );
};

export default People;
