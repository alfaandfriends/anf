<script>
import { ref, onMounted, onBeforeUnmount, watch } from "vue";
import {
  Accordion,
  AccordionContent,
  AccordionItem,
  AccordionTrigger,
} from "@/Components/ui/accordion";
import { CheckCircle2, OctagonAlert } from "lucide-vue-next";

export default {
  components: {
    Accordion,
    AccordionContent,
    AccordionItem,
    AccordionTrigger,
    OctagonAlert,
    CheckCircle2,
  },
  setup() {
    const panel = ref(null);
    const isDragging = ref(false);
    const offset = ref({ x: 0, y: 0 });

    // Load saved position or default
    const loadPosition = () => {
      const savedPos = JSON.parse(localStorage.getItem("notifPosition"));
      return savedPos && savedPos.x !== undefined && savedPos.y !== undefined
        ? savedPos
        : { x: window.innerWidth / 2 - 150, y: 20 };
    };

    const position = ref(loadPosition());

    // Load open/close state from localStorage
    const storedValue = localStorage.getItem("notifOpen");

    // Check if storedValue is valid JSON
    const isValidJson = storedValue !== null && storedValue !== "undefined";

    if (!isValidJson) {
      localStorage.setItem("notifOpen", JSON.stringify(true));
    }

    const isOpen = ref(isValidJson ? JSON.parse(storedValue) : true);

    const savePosition = () => {
      localStorage.setItem("notifPosition", JSON.stringify(position.value));
    };

    const saveOpenState = () => {
      localStorage.setItem("notifOpen", JSON.stringify(isOpen.value));
    };

    const startDrag = (event) => {
      isDragging.value = true;
      offset.value = {
        x: (event.touches?.[0] || event).clientX - position.value.x,
        y: (event.touches?.[0] || event).clientY - position.value.y,
      };
    };

    const onDrag = (event) => {
      if (!isDragging.value) return;

      const clientX = (event.touches?.[0] || event).clientX;
      const clientY = (event.touches?.[0] || event).clientY;

      const maxX = window.innerWidth - panel.value.clientWidth;
      const maxY = window.innerHeight - panel.value.clientHeight;

      position.value = {
        x: Math.max(0, Math.min(clientX - offset.value.x, maxX)),
        y: Math.max(0, Math.min(clientY - offset.value.y, maxY)),
      };

      savePosition(); // Save position after every move
    };

    const stopDrag = () => {
      isDragging.value = false;
      savePosition();
    };

    watch(isOpen, saveOpenState); // Save open/close state when changed

    onMounted(() => {
      document.addEventListener("mousemove", onDrag);
      document.addEventListener("mouseup", stopDrag);
      document.addEventListener("touchmove", onDrag);
      document.addEventListener("touchend", stopDrag);
    });

    onBeforeUnmount(() => {
      document.removeEventListener("mousemove", onDrag);
      document.removeEventListener("mouseup", stopDrag);
      document.removeEventListener("touchmove", onDrag);
      document.removeEventListener("touchend", stopDrag);
    });

    return {
      panel,
      position,
      isOpen,
      startDrag,
    };
  },
};
</script>

<template>
  <div
    ref="panel"
    class="fixed bg-zinc-800 text-white rounded-lg shadow-lg cursor-move"
    :style="{
      top: position.y + 'px',
      left: position.x + 'px',
      transform: 'none',
    }"
    @mousedown="startDrag"
    @touchstart="startDrag"
  >
    <Accordion type="single" collapsible v-model="isOpen">
      <AccordionItem value="notification" class="border-0">
        <AccordionTrigger
          class="text-white px-5 mb-0 min-w-72 border-b border-dashed border-b-slate-400"
        >
          <div class="flex items-center gap-1 text-xs text-red-400">
            <OctagonAlert class="w-5 h-5" />
            <span class="whitespace-pre select-none font-medium tracking-wide">
              You have pending tasks
            </span>
          </div>
          <!-- <div class="flex items-center gap-1 text-xs text-green-400">
            <CheckCircle2 class="w-5 h-5" />
            <span class="whitespace-pre select-none font-medium tracking-wide">
              All tasks have been completed
            </span>
          </div> -->
        </AccordionTrigger>
        <AccordionContent class="cursor-default">
          <div class="mt-4 px-6 py-0.5 text-xs">
            <ul class="list-disc list-inside">
              <li>The progress report has not been completed yet.</li>
            </ul>
          </div>
        </AccordionContent>
      </AccordionItem>
    </Accordion>
  </div>
</template>
