<template>

  <button @click="isDelete = !isDelete" class="w-8 h-8 rounded-md flex items-center justify-center bg-red-400/10 border border-red-900">
    <Icon name="material-symbols:delete-outline" class="text-lg text-red-900"/>
  </button>


  <Transition name="fade">
    <div id="deleteModal" tabindex="-1" v-if="isDelete"  class="grid place-items-center overflow-y-auto bg-black/50 backdrop-blur-sm overflow-x-hidden fixed z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
      <div class="relative p-4 w-full max-w-md h-full md:h-auto">
        <!-- Modal content -->
        <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
          <button @click="isDelete = false" type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="deleteModal">
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            <span class="sr-only">Close modal</span>
          </button>
          <svg class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
          <p class="mb-4 text-gray-500 dark:text-gray-300">Are you sure you want to delete this item?</p>
          <slot name="instruction"></slot>
          <div class="flex justify-center items-center space-x-4">
            <button @click="isDelete = false" data-modal-toggle="deleteModal" type="button" class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
              No, cancel
            </button>
            <button @click="handelDelete" type="submit" :disabled="loading" :class="loading ? 'bg-red-200 ' : 'bg-red-600 hover:bg-red-700'" class="py-2 px-3 text-sm font-medium text-center text-white rounded-lg  focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
              Yes, I'm sure
            </button>
          </div>
        </div>
      </div>
    </div>
  </Transition>
</template>

<script setup>
  import {ref} from "vue";
  import useAxios from "@/composables/useAxios.js";
  import {useToast} from "vue-toastification";
  const { path } = defineProps({ path:String })
  const isDelete = ref(false);
  const {sendRequest, loading, error } = useAxios()
  const toast = useToast();
  const emit = defineEmits(['deleted']);

  const handelDelete = async () => {
    const response = await sendRequest({url: path, method: 'DELETE'})
    toast.success(response.data?.message ?? 'Deleted Successfully Done...')
    emit('deleted')
  }

</script>

<style lang="css">
.fade-enter-active,
.fade-leave-active {
  transition: 0.2s all ease-in-out;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>