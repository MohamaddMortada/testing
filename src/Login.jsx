import React, { useState } from 'react';
import axios from 'axios';

const Login = () => {
    const [username, setUsername] = useState('');
    const [password, setPassword] = useState('');
    const [message, setMessage] = useState('');
    const [token, setToken] = useState('');

    const handleSubmit = async (e) => {
        e.preventDefault();

        try {
            const response = await axios.post('http://localhost/e-learning-test/src/login.php', {
                username,
                password,
            });
            setMessage(response.data.message);
            if (response.data.token) {
                localStorage.setItem('jwt', response.data.token); // Save the token
                setToken(response.data.token);
            }
        } catch (error) {
            setMessage('Error: ' + error.response.data.message);
        }
    };

    return (
        <div>
            <h2>Login</h2>
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
                <button type="submit">Login</button>
            </form>
            {message && <p>{message}</p>}
            {token && <p>Logged in with token: {token}</p>}
        </div>
    );
};

export default Login;
