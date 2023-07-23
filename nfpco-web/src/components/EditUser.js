import React from "react";
import { useState, useEffect } from "react";
import axios from "axios";
import { useNavigate, useParams } from "react-router-dom";

export default function EditUser() {
    const navigate = useNavigate();
    const [inputs, setInputs] = useState([]);
    const {id} = useParams();
    useEffect(() => {
        getUser();
    }, []);
    function getUser() {
        axios.get(`http://localhost/api/user/${id}`).then(function(response) {
            setInputs(response.data);
        });
    }
    const handleChange = (event) => {
        const name = event.target.name;
        const value = event.target.value;
        setInputs(values => ({...values, [name]: value}));
    }
    const handleSubmit = (event) => {
        event.preventDefault();
        console.log(' inputsvalues='+JSON.stringify(inputs));
        axios.put(`http://localhost/api/user/${id}/edit`, inputs).then(function(response){
            console.log(response.data);
            navigate('/');
        });

    }
    return (
        <div>
            <h1>Edit user</h1>
            <form onSubmit={handleSubmit}>
                <table cellSpacing="10">
                    <tbody>
                        <tr>
                            <th>
                                <label>First Name: </label>
                            </th>
                            <td>
                                <input value={inputs.first_name} type="text" name="first_name" onChange={handleChange} />
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label>Last Name: </label>
                            </th>
                            <td>
                                <input value={inputs.last_name} type="text" name="last_name" onChange={handleChange} />
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label>Email: </label>
                            </th>
                            <td> 
                                <input value={inputs.email} type="text" name="email" onChange={handleChange} />
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label>Mobile: </label>
                            </th>
                            <td>
                                <input value={inputs.phone} type="text" name="phone" onChange={handleChange} />
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label>Gender: </label>
                            </th>
                            <td>
                                <input value={inputs.gender} type="text" name="gender" onChange={handleChange} />
                            </td>
                        </tr>
                        <tr>
                            <td colSpan="2" align ="right">
                                <button>Save</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    )
}