import React from 'react';

const People = ({ people }) => {
    return (
        <div className="mt-6">
            <h3 className="text-lg font-semibold text-gray-800">People List</h3>
            <div className="mt-4">
                {people.length === 0 ? (
                    <p className="text-gray-500">No people found.</p>
                ) : (
                    <ul className="space-y-4">
                        {people.map((person) => (
                            <li key={person.id} className="p-4 border rounded-lg shadow">
                                <h4 className="font-bold">{person.name}</h4>
                                <p className="text-gray-600">{person.email}</p>
                                {/* Add any other relevant fields you want to display */}
                            </li>
                        ))}
                    </ul>
                )}
            </div>
        </div>
    );
};

export default People;
