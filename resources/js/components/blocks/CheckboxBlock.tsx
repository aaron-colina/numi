import Numi from "@/contexts/Numi";
import { BlockContextType } from "@/types/blocks";
import { Switch } from "@/components/ui/switch";

function CheckboxBlockComponent({ context }: { context: BlockContextType }) {

  const [checked, setChecked] = Numi.useStateBoolean({
    name: 'value',
    defaultValue: false,
    inspector: 'hidden',
  });

  const [isDefaultChecked, setIsDefaultChecked] = Numi.useStateBoolean({
    name: 'is_default_checked',
    defaultValue: false,
  });

  const [appearance] = Numi.useStateEnumeration({
    name: 'appearance',
    initialValue: 'checkbox',
    options: ['checkbox', 'switch'],
    labels: {
      checkbox: 'Checkbox',
      switch: 'Switch',
    } as Record<string, string>,
    inspector: 'select',
    label: 'Appearance',
  });

  const [label] = Numi.useStateString({
    name: 'label',
    defaultValue: 'Checked?',
  });

  function handleChange() {
    setChecked(!checked);
  }

  // validation rules~
  // const { isValid, errors, validate } = Numi.useValidation({
  //   isRequired: false,
  // }); 

  return (
    <div>
      <div className="text-xs bg-gray-100">
        CheckboxBlockComponent: {context.blockId} label:{label} {checked ? 'checked' : 'unchecked'} {appearance}</div>
      <div>
        {appearance === 'checkbox' && (
          <div>
            <input type="checkbox" name={context.blockId} checked={checked} onChange={handleChange} /> {label}
          </div>
        )}
        {appearance === 'switch' && (
          <div className="flex items-center gap-2"> 
            <Switch
              checked={checked}
              onCheckedChange={handleChange}
            /> {label}
          </div>
        )}
      </div>
      {/* isDirty? how to clean? */}
      {/* {!isValid && errors.map((error, i) => (
        <div key={i} className="text-red-500 text-sm mt-1">{error}</div>
      ))} */}
    </div>
  );
}

export default CheckboxBlockComponent;