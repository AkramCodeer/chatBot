<template>
  <div class="container-fluid py-4">
    <div class="card p-4">
      <h2 class="mb-4">Phone Bot Dashboard</h2>

      <!-- Phone Bot Selection as Cards -->
      <div class="mb-4">
        <h4>Select Phone Bot:</h4>
        <div class="d-flex flex-wrap">
          <div
            v-for="bot in phoneBots"
            :key="bot.id"
            class="phone-bot-card"
            :class="{ selected: selectedBot === bot.id }"
            @click="selectBot(bot.id)"
          >
            <img :src="bot.image" alt="" class="phone-bot-image" />
            <div class="phone-bot-name">{{ bot.name }}</div>
            <div class="phone-bot-description">Description about {{ bot.name }}</div>
          </div>
        </div>
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

    <!-- Render Table of Saved Issues -->
    <div v-if="savedIssues.length > 0" class="card mt-4 p-4">
      <h4>Saved</h4>
      <table class="table table-bordered mt-3">
        <thead>
          <tr>
            <th>Phone Bot</th>
            <th>Subject</th>
            <th>Issue Details</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="issue in savedIssues" :key="issue.id">
            <td>{{ issue.botName }}</td>
            <td>{{ issue.subject }}</td>
            <td>{{ issue.details }}</td>
          </tr>
        </tbody>
      </table>
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
        { id: 'adobe', name: 'Adobe', image: 'https://imgs.search.brave.com/uqgYGWgjqOMb3wj3h0il3bVxowWdiQNJ6VumGUvlwnk/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9jZG4t/aWNvbnMtcG5nLmZs/YXRpY29uLmNvbS8x/MjgvODg4Lzg4ODgz/NS5wbmc' },
        { id: 'zoom', name: 'Zoom', image: 'https://img.icons8.com/color/48/000000/zoom.png' },
        { id: 'reddit', name: 'Reddit', image: 'https://img.icons8.com/fluency/48/000000/reddit.png' },
        { id: 'github', name: 'GitHub', image: 'https://img.icons8.com/ios-filled/50/000000/github.png' },
        { id: 'microsoft-teams', name: 'Microsoft Teams', image: 'https://img.icons8.com/color/48/000000/microsoft-teams.png' },
        { id: 'discord', name: 'Discord', image: 'https://img.icons8.com/color/48/000000/discord-new-logo.png' },
      ],
      savedIssues: [], // Holds the list of saved issues
    };
  },
  mounted() {
    // Load saved issues from localStorage when the component is mounted
    const issues = localStorage.getItem("issues");
    if (issues) {
      this.savedIssues = JSON.parse(issues);
    }
  },
  methods: {
    selectBot(botId) {
      this.selectedBot = botId;
    },
    saveConfiguration() {
      const newIssue = {
        id: Date.now(),
        botName: this.phoneBots.find(bot => bot.id === this.selectedBot)?.name,
        subject: this.subject,
        details: this.issueDetails,
      };

      // Add the new issue to the savedIssues array
      this.savedIssues.push(newIssue);

      // Save the issues to localStorage
      localStorage.setItem("issues", JSON.stringify(this.savedIssues));

      // Reset the form
      this.selectedBot = null;
      this.subject = "";
      this.issueDetails = "";

      alert("Configuration saved successfully!");
    },
  },
};
</script>

<style scoped>
/* Existing styles remain the same */
.card {
  border: 1px solid #ddd;
  border-radius: 8px;
  background-color: #fff;
  padding: 20px;
}

.phone-bot-card {
  border: 1px solid #ddd;
  border-radius: 8px;
  padding: 10px;
  margin: 10px;
  width: 150px;
  text-align: center;
  cursor: pointer;
  transition: transform 0.2s, box-shadow 0.2s;
}

.phone-bot-card.selected {
  border-color: #007bff;
  box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
  transform: scale(1.05);
}

.phone-bot-card:hover {
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.phone-bot-image {
  width: 48px;
  height: 48px;
}

.phone-bot-name {
  font-weight: bold;
  margin-top: 10px;
}

.phone-bot-description {
  font-size: 0.9em;
  color: #777;
  margin-top: 5px;
}

.form-label {
  font-weight: bold;
}

.border-primary {
  border: 2px solid black; /* Blue border for input and textarea */
}
</style>
