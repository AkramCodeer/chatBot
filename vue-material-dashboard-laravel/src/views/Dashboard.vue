<template>
  <div class="container-fluid py-4">
    <div class="card p-4">
      <h2 class="mb-4">Phone Bot Dashboard</h2>

      <!-- Phone Bot Selection -->
      <div class="mb-4">
        <label for="phoneBot" class="form-label">Select Phone Bot:</label>
        <select id="phoneBot" class="form-select mb-4" v-model="selectedBot">
          <option v-for="bot in phoneBots" :key="bot.id" :value="bot.id">
            <img :src="bot.image" alt="" class="me-2" style="width: 24px; height: 24px; vertical-align: middle;">
            {{ bot.name }}
          </option>
        </select>
      </div>

      <!-- Subject and Details -->
      <div class="mb-4">
        <h4 class="mb-3">Subject and Details</h4>
        <div class="mb-3">
          <label for="subject" class="form-label">Subject:</label>
          <input type="text" id="subject" class="form-control border border-primary" v-model="subject" />
        </div>
        <div class="mb-3">
          <label for="issueDetails" class="form-label">Issue Details:</label>
          <textarea id="issueDetails" class="form-control border border-primary" rows="4" v-model="issueDetails"></textarea>
        </div>
      </div>

      <!-- Save Button -->
      <div class="text-end">
        <button class="btn btn-primary" @click="saveConfiguration">Save Configuration</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      selectedBot: null,
      subject: "",
      issueDetails: "",
      phoneBots: [
        { id: 'slack', name: 'Slack', image: 'https://img.icons8.com/color/48/000000/slack-new.png' },
        { id: 'spotify', name: 'Spotify', image: 'https://img.icons8.com/color/48/000000/spotify.png' },
        { id: 'adobe', name: 'Adobe', image: 'https://img.icons8.com/ios/50/000000/adobe.png' },
        { id: 'zoom', name: 'Zoom', image: 'https://img.icons8.com/color/48/000000/zoom.png' },
      ],
    };
  },
  methods: {
    saveConfiguration() {
      alert("Configuration saved successfully!");
      console.log("Selected Bot:", this.selectedBot);
      console.log("Subject:", this.subject);
      console.log("Issue Details:", this.issueDetails);
    },
  },
};
</script>

<style scoped>
.card {
  border: 1px solid #ddd;
  border-radius: 8px;
  background-color: #fff;
  padding: 20px;
}

.form-label {
  font-weight: bold;
}

.form-select {
  margin-bottom: 16px; /* Margin from bottom */
}

.form-select img {
  margin-right: 8px;
  vertical-align: middle;
}

.border-primary {
  border: 2px solid black; /* Blue border for input and textarea */
}
</style>
