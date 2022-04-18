<template>
  <file-manager :settings="settings"></file-manager>
</template>

<script>
export default {
  props: {
    settings: {
      type: Object,
      required: true,
      default: {
        windowsConfig: 2,
      },
    },
  },
};
</script>