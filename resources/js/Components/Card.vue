<template>
    <div class="bg-gray-900 border border-gray-800 rounded-xl p-6 shadow-lg hover:border-neon-cyan transition-colors duration-300 relative overflow-hidden group">
        <div class="absolute inset-0 bg-gradient-to-br from-neon-cyan/5 to-neon-pink/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <div class="relative z-10">
            <slot />
        </div>
    </div>
</template>
