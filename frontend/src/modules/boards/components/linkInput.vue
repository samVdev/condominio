<script lang="ts" setup>
import { ref, watch, nextTick } from 'vue'

const props = defineProps({
  modelValue: {
    type: String,
    default: ''
  },
  placeholder: {
    type: String,
    default: 'Sin enlace'
  },
  disabled: {
    type: Boolean,
    default: false
  },
  showControls: {
    type: Boolean,
    default: true
  }
})

const emit = defineEmits(['changeLink'])

const isEditing = ref(false)
const editedValue = ref(props.modelValue)
const inputField = ref(null)

watch(() => props.modelValue, (newVal) => {
  editedValue.value = newVal
})

const startEditing = () => {
  if (props.disabled) return
  
  isEditing.value = true
  editedValue.value = props.modelValue
  
  nextTick(() => {
    inputField.value?.focus()
  })
}

const saveChanges = () => {
  isEditing.value = false
  if (editedValue.value !== props.modelValue) {
    emit('changeLink', editedValue.value)
  }
}

const cancelEditing = () => {
  isEditing.value = false
  editedValue.value = props.modelValue
}
</script>

<template>
  <div class="editable-input-container">
    <div v-if="!isEditing" class="flex items-center gap-2">
      <div 
        class="display-mode flex-grow" 
        @click="startEditing"
        :class="{'cursor-pointer hover:bg-gray-50': !disabled}"
      >
        <span v-if="modelValue">{{ modelValue }}</span>
        <span v-else class="text-gray-400">{{ placeholder }}</span>
      </div>
      
      <button 
        v-if="showControls && !disabled"
        @click="startEditing"
        class="p-1 text-gray-500 hover:text-gray-700 transition-colors"
        title="Editar"
      >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
        </svg>
      </button>
    </div>
    
    <div v-else class="flex items-center gap-2">
      <input
        ref="inputField"
        v-model="editedValue"
        type="text"
        class="input-field flex-grow"
        @keyup.enter="saveChanges"
        @keyup.escape="cancelEditing"
        :placeholder="placeholder"
        :disabled="disabled"
      />
      
      <div v-if="showControls" class="flex gap-1">
        <button
          @click="saveChanges"
          class="p-1 text-green-600 hover:text-green-800 transition-colors"
          title="Guardar"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
        </button>
        
        <button
          @click="cancelEditing"
          class="p-1 text-red-600 hover:text-red-800 transition-colors"
          title="Cancelar"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </div>
  </div>
</template>

<style scoped>
.editable-input-container {
  @apply w-full;
}

.display-mode {
  @apply p-2 rounded border border-transparent min-h-[40px] flex items-center;
}

.input-field {
  @apply w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent;
}
</style>