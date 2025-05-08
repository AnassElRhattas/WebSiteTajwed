<template>
    <div class="p-4 bg-white rounded-xl shadow">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">قواعد التجويد</h2>
        <ul class="flex flex-wrap gap-4">
            <li v-for="rule in tajweedRules" :key="rule.id" class="flex items-center gap-2 min-w-[200px]">
                <span class="text-lg text-gray-700 font-arabic">{{ rule.name }}</span>
                <span class="w-3 h-3 rounded-full border" :style="{ backgroundColor: rule.color }"
                    :title="rule.id"></span>
            </li>
        </ul>
    </div>
</template>

<style scoped>
.font-arabic {
    font-family: 'Traditional Arabic', 'Amiri', serif;
    font-size: 1.35rem;
    line-height: 1.75;
}
</style>

<script>
export default {
    name: 'TajweedLegend',
    data() {
        return {
            tajweedRules: [
                { id: 'ham_wasl', name: 'همزة الوصل', color: '#AAAAAA' },
                { id: 'slnt', name: 'اللام الشمسية', color: '#AAAAAA' },
                { id: 'madda_normal', name: 'المد الطبيعي (حركتان)', color: '#537FFF' },
                { id: 'madda_permissible', name: 'المد الجائز (٢، ٤، ٦ حركات)', color: '#4050FF' },
                { id: 'madda_necessary', name: 'المد اللازم (٦ حركات)', color: '#000EBC' },
                { id: 'madda_pbligatory', name: 'المد الواجب (٤-٥ حركات)', color: '#2144C1' },
                { id: 'qlq', name: 'القلقلة', color: '#DD0008' },
                { id: 'ikhf_shfw', name: 'الإخفاء الشفوي', color: '#D500B7' },
                { id: 'ikhf', name: 'الإخفاء', color: '#9400A8' },
                { id: 'idghm_shfw', name: 'الإدغام الشفوي', color: '#58B800' },
                { id: 'iqlb', name: 'الإقلاب', color: '#26BFFD' },
                { id: 'idgh_ghn', name: 'الإدغام بغنة', color: '#169777' },
                { id: 'idgh_w_ghn', name: 'الإدغام بغير غنة', color: '#169200' },
                { id: 'idgh_mus', name: 'إدغام المتجانسين / المتقاربين', color: '#A1A1A1' },
                { id: 'ghn', name: 'الغنة (حركتان)', color: '#FF7E1E' },
            ],
        };
    },
};
</script>>
