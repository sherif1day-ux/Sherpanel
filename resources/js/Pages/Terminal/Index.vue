<script setup>
import AppLayout from '@/Components/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import { Terminal } from 'xterm';
import { FitAddon } from 'xterm-addon-fit';
import 'xterm/css/xterm.css';
import axios from 'axios';

const terminalContainer = ref(null);

onMounted(() => {
    const term = new Terminal({
        theme: {
            background: '#0a0a12',
            foreground: '#00f3ff',
            cursor: '#ff00ff',
            selection: '#bc13fe',
        },
        fontFamily: '"Fira Code", monospace',
        fontSize: 14,
        cursorBlink: true,
        convertEol: true, 
    });
    
    const fitAddon = new FitAddon();
    term.loadAddon(fitAddon);
    
    term.open(terminalContainer.value);
    fitAddon.fit();
    
    term.writeln('\x1b[1;36mSherPanel Web Terminal v1.0\x1b[0m');
    term.writeln('Restricted Shell. Type commands like `ls`, `whoami`, `date`.');
    term.write('\r\n$ ');

    let currentLine = '';

    term.onData(data => {
        // Handle Enter
        if (data === '\r') {
            term.write('\r\n');
            if (currentLine.trim().length > 0) {
                // Execute command
                axios.post(route('terminal.execute'), { command: currentLine })
                    .then(response => {
                        // Ensure line endings are correct for xterm
                        const output = response.data.output.replace(/\n/g, '\r\n');
                        term.write(output);
                        if (!output.endsWith('\n')) {
                             term.write('\r\n');
                        }
                    })
                    .catch(error => {
                        const errMsg = error.response?.data?.output || error.message;
                         term.write(`\x1b[31mError: ${errMsg}\x1b[0m\r\n`);
                    })
                    .finally(() => {
                        term.write('$ ');
                        currentLine = '';
                    });
            } else {
                 term.write('$ ');
            }
        } 
        // Handle Backspace
        else if (data === '\u007F') { 
            if (currentLine.length > 0) {
                currentLine = currentLine.slice(0, -1);
                term.write('\b \b');
            }
        } 
        // Handle printable characters
        else {
            currentLine += data;
            term.write(data);
        }
    });

    window.addEventListener('resize', () => fitAddon.fit());
});
</script>

<template>
    <Head title="Terminal" />

    <AppLayout>
        <template #header>
            Web Terminal
        </template>

        <div class="h-[calc(100vh-12rem)] bg-[#0a0a12] border border-gray-800 rounded-lg p-2 shadow-[0_0_20px_rgba(0,243,255,0.1)]">
            <div ref="terminalContainer" class="h-full w-full"></div>
        </div>
    </AppLayout>
</template>
