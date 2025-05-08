<template>
    <div class="p-4 bg-white rounded-xl shadow space-y-4">
        <h2 class="text-xl font-semibold text-gray-800">Légende des règles de Tajwid</h2>
        <ul class="space-y-2">
            <li v-for="rule in tajweedRules" :key="rule.id" class="flex items-center gap-4">
                <span class="w-6 h-6 rounded-full border" :style="{ backgroundColor: rule.color }"
                    :title="rule.id"></span>
                <span class="text-gray-700">{{ rule.name }}</span>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: 'TajweedLegend',
    data() {
        return {
            tajweedRules: [
                { id: 'ham_wasl', name: 'Hamzat ul Wasl', color: '#AAAAAA' },
                { id: 'slnt', name: 'Silent / Lam Shamsiyyah', color: '#AAAAAA' },
                { id: 'madda_normal', name: 'Normal Prolongation (2 vowels)', color: '#537FFF' },
                { id: 'madda_permissible', name: 'Permissible Prolongation (2, 4, 6 vowels)', color: '#4050FF' },
                { id: 'madda_necessary', name: 'Necessary Prolongation (6 vowels)', color: '#000EBC' },
                { id: 'madda_pbligatory', name: 'Obligatory Prolongation (4–5 vowels)', color: '#2144C1' },
                { id: 'qlq', name: 'Qalaqah', color: '#DD0008' },
                { id: 'ikhf_shfw', name: 'Ikhafa\' Shafawi', color: '#D500B7' },
                { id: 'ikhf', name: 'Ikhafa\'', color: '#9400A8' },
                { id: 'idghm_shfw', name: 'Idgham Shafawi', color: '#58B800' },
                { id: 'iqlb', name: 'Iqlab', color: '#26BFFD' },
                { id: 'idgh_ghn', name: 'Idgham avec Ghunnah', color: '#169777' },
                { id: 'idgh_w_ghn', name: 'Idgham sans Ghunnah', color: '#169200' },
                { id: 'idgh_mus', name: 'Idgham Mutajanisayn / Mutaqaribayn', color: '#A1A1A1' },
                { id: 'ghn', name: 'Ghunnah (2 vowels)', color: '#FF7E1E' },
            ],
        };
    },
};
</script>