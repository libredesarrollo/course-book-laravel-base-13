<template>
    <div class="container mx-auto">
        <div class="mt-6 mb-2 px-6 py-4 bg-white shadow-md rounded-md">
            <h1 class="text-xl font-bold mb-4">Notificaciones en vivo (SSE)</h1>

            <div class="mb-4">
                <o-button
                    v-if="!isConnected"
                    iconLeft="play"
                    variant="success"
                    @click="connect"
                >
                    Conectar
                </o-button>
                <o-button
                    v-else
                    iconLeft="stop"
                    variant="danger"
                    @click="disconnect"
                >
                    Desconectar
                </o-button>
            </div>

            <p v-if="isConnected" class="mb-4 text-green-600 font-semibold">
                Conectado al stream de eventos...
            </p>
            <p v-else class="mb-4 text-gray-500">
                {{ messages.length > 0 ? 'Stream cerrado.' : 'Conecta para empezar a recibir notificaciones.' }}
            </p>

            <ul v-if="messages.length > 0" class="space-y-2">
                <li
                    v-for="(msg, index) in messages"
                    :key="index"
                    class="border border-gray-200 rounded-md px-4 py-2"
                >
                    <strong>[{{ msg.time }}]:</strong> {{ msg.message }}
                </li>
            </ul>

            <p v-else class="text-gray-400 italic">
                Aún no hay notificaciones.
            </p>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            messages: [],
            eventSource: null,
            isConnected: false,
        }
    },
    beforeUnmount() {
        this.disconnect()
    },
    methods: {
        connect() {
            // Conectamos a la ruta SSE de Laravel
            this.eventSource = new EventSource('/api/v1/events')

            this.eventSource.onopen = () => {
                this.isConnected = true
            }

            // Se ejecuta cada vez que el servidor envía un "data: ..."
            this.eventSource.onmessage = (event) => {
                const dataParsed = JSON.parse(event.data)
                this.messages.push(dataParsed)
            }

            // El servidor avisa con un evento "closed" al terminar el stream
            this.eventSource.addEventListener('closed', () => {
                console.log('Stream finalizado, cerrando conexión.')
                this.disconnect()
            })

            // Manejo de errores; EventSource intentará reconectarse automáticamente
            this.eventSource.onerror = () => {
                // readyState 0 = CONNECTING (error transitorio, se reintenta solo);
                // readyState 2 = CLOSED (el servidor cerro la conexión).
                if (this.eventSource.readyState === EventSource.CLOSED) {
                    this.isConnected = false
                }
            }
        },
        disconnect() {
            if (this.eventSource) {
                this.eventSource.close()
                this.eventSource = null
                this.isConnected = false
            }
        },
    },
}
</script>