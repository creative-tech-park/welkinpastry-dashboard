<script setup>
import useAxios from "@/composables/useAxios"
import {ref, onMounted} from "vue";
import Input from "@/components/Input.vue";
import LoadingButton from "@/components/LoadingButton.vue";
import {useToast} from "vue-toastification";
import {useRoute} from "vue-router";
const toast = useToast();
const route = useRoute()
const {loading, error, sendRequest} = useAxios();

const form = ref({
  name: null,
  full_address: null,
});

const onSubmit = async () => {
  const response = await sendRequest({
    method: 'post',
    url: '/v1/location',
    data: form.value
  });
  toast.success("Action SSuccessfully WWorked");
}

const getLocation = async () => {
  const response = await sendRequest({
    method: 'get',
    url: `/v1/location/${route?.params?.id}`,
  });

  form.value = response.data
}

onMounted(async () => {
  if (route?.params?.id) await getLocation()
})

</script>
<template>
  <AppLayout>
    <div class="bg-white shadow-md p-6 max-w-5xl mx-auto">
      <h3 class="mb-10">Create a New Location</h3>
      <div>
        <div class="flex items-start flex-wrap">
          <div class="w-full pr-2">
            <Input label-name="Localtion Name"
                   v-model="form.name"
                   label="Localtion Name"
                   :error="error?.response?.data?.errors?.name"
                   :loading="loading"
            />
          </div>
        </div>
        <div class="w-full mb-4">
          <label for="short-description" class="text-sm block mb-2">Full Address</label>
          <textarea class="w-full h-20 rounded border p-2 disabled:bg-gray-200"
                    :disabled="loading"
                    v-model="form.full_address"></textarea>
        </div>
      </div>
      <div class="mt-5">
        <LoadingButton class="w-max" @click="onSubmit" :isLoading="loading">
          Save
        </LoadingButton>
      </div>
    </div>
  </AppLayout>
</template>

<style scoped>

</style>