import React from 'react';
import { createRoot } from 'react-dom/client';

function Welcome() {
    return <h1>Olá, mundo React!</h1>;
}

const root = createRoot(document.getElementById('app'));
root.render(<Welcome />);