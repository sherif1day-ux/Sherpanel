<template>
    <button :type="type" class="px-4 py-2 bg-gray-800 border border-neon-cyan text-neon-cyan rounded-lg hover:bg-neon-cyan hover:text-black font-bold transition-all duration-300 shadow-[0_0_10px_rgba(0,243,255,0.2)] hover:shadow-[0_0_20px_rgba(0,243,255,0.6)]">
        <slot />
    </button>
</template>

<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>
