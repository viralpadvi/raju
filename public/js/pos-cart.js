export default {
  name: 'PosCart',
  data() {
    return {
      items: [],
    };
  },
  computed: {
    total() {
      return this.items.reduce((sum, i) => sum + i.price * i.qty, 0);
    },
  },
  watch: {
    total(newTotal) {
      window.dispatchEvent(new CustomEvent('pos-total-changed', { detail: { total: newTotal } }));
    }
  },
  mounted() {
    window.dispatchEvent(new CustomEvent('pos-total-changed', { detail: { total: this.total } }));
  },
  methods: {
    addDemoItem() {
      this.items.push({ id: Date.now(), name: 'Demo', price: 0, qty: 1 });
    },
    remove(id) {
      this.items = this.items.filter(i => i.id !== id);
    },
  },
  template: `
    <div>
      <div class="d-flex align-items-center justify-content-between mb-2">
        <button class="btn btn-link btn-sm p-0" @click="addDemoItem">Add demo item</button>
        <div class="small text-muted">Items: {{ items.length }}</div>
      </div>
      <ul class="list-group list-group-flush">
        <li v-for="i in items" :key="i.id" class="list-group-item d-flex align-items-center justify-content-between">
          <div class="text-truncate">
            <div class="small fw-medium text-truncate">{{ i.name }}</div>
            <div class="small text-muted">Qty: {{ i.qty }} × {{ i.price.toFixed(2) }}</div>
          </div>
          <button class="btn btn-sm btn-outline-danger" @click="remove(i.id)">Remove</button>
        </li>
      </ul>
      <div class="text-end fw-semibold mt-2">Total: {{ total.toFixed(2) }}</div>
    </div>
  `,
};


