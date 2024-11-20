import React, { useState } from 'react';
import axios from 'axios';

const Register = () => {
    const [username, setUsername] = useState('');
    const [password, setPassword] = useState('');
    const [message, setMessage] = useState('');

    const handleSubmit = async (e) => {
        e.preventDefault();
    
        console.log({ username, password });  // Log form data to check
    
        try {
            const response = await axios.post('http://localhost/e-learning-test/src/register.php', {
                username,
                password,
            }, {
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded', // Ensure correct content type
                }
            });
            console.log(response.data); // Log the response from the server
            setMessage(response.data.message);
        } catch (error) {
            console.log(error.response ? error.response : error);  // Log the full error
            setMessage('Error: ' + (error.response ? error.response.data.message : error.message));
        }
    };
    

    return (
        <div>
            <h2>Register</h2>
            <form onSubmit={handleSubmit}>
                <input 
                    type="text" 
                    placeholder="Username" 
                    value={username} 
                    onChange={(e) => setUsername(e.target.value)} 
                />
                <input 
                    type="password" 
                    placeholder="Password" 
                    value={password} 
                    onChange={(e) => setPassword(e.target.value)} 
                />
                <button type="submit">Register</button>
            </form>
            {message && <p>{message}</p>}
        </div>
    );
};

export default Register;
