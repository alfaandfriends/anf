export { default as Toaster } from "./Toaster.vue";
export { default as Toast } from "./Toast.vue";
export { default as ToastViewport } from "./ToastViewport.vue";
export { default as ToastAction } from "./ToastAction.vue";
export { default as ToastClose } from "./ToastClose.vue";
export { default as ToastTitle } from "./ToastTitle.vue";
export { default as ToastDescription } from "./ToastDescription.vue";
export { default as ToastProvider } from "./ToastProvider.vue";
export { toast, useToast } from "./use-toast";

import { cva } from "class-variance-authority";

export const toastVariants = cva(
  "group pointer-events-auto relative flex w-full items-center justify-between space-x-2 overflow-hidden rounded-md border border-slate-200 p-4 pr-6 shadow-lg transition-all data-[swipe=cancel]:translate-x-0 data-[swipe=end]:translate-x-[var(--radix-toast-swipe-end-x)] data-[swipe=move]:translate-x-[var(--radix-toast-swipe-move-x)] data-[swipe=move]:transition-none data-[state=open]:animate-in data-[state=closed]:animate-out data-[swipe=end]:animate-out data-[state=closed]:fade-out-80 data-[state=closed]:slide-out-to-right-full data-[state=open]:slide-in-from-top-full data-[state=open]:sm:slide-in-from-bottom-full dark:border-slate-800",
  {
    variants: {
      variant: {
        default:
          "border bg-white text-slate-950 dark:bg-slate-950 dark:text-slate-50",
        error:
          "destructive group border-red-500 bg-red-200 text-red-600 dark:border-red-900 dark:bg-red-900 dark:text-slate-50",
        success:
          "group border-green-500 bg-green-200 text-green-600 dark:border-green-900 dark:bg-green-900 dark:text-slate-50",
      },
    },
    defaultVariants: {
      variant: "default",
    },
  },
);
