import React from 'react';
import axios from 'axios';
import { useEffect, useState } from "react";
import { Link } from "react-router-dom";
import { useNavigate } from "react-router-dom";

export default function ListUser() {
    const navigate = useNavigate();
    const [users, setUsers] = useState([]);
    useEffect(() => {
        getUsers();
    }, []);
    function getUsers() {
        axios.get('http://localhost/api/users/').then(function(response) {
            setUsers(response.data);
        });
    }
    const handleDelete = (userId) => {
        axios.delete(`http://localhost/api/user/${userId}`).then(function(response){
            console.log(response.data);
            navigate('/');
        });

    }
    return (
        <div>
            <h1>List Users</h1>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Gender</th>
                    </tr>
                </thead>
                <tbody>
                    {
                    users.map((user, key) =>
                        <tr key={key}>
                            <td>{user.user_id}</td>
                            <td>{user.first_name}</td>
                            <td>{user.last_name}</td>
                            <td>{user.email}</td>
                            <td>{user.phone}</td>
                            <td>{user.gender}</td>
                            <td>
                                <Link to={`user/${user.user_id}/edit`} style={{marginRight: "10px"}}>Edit</Link>
                                <button onClick={()=>handleDelete(user.user_id)}>Delete</button>
                            </td>
                        </tr>
                    )}

                </tbody>
            </table>
        </div>
    )
}