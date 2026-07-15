import React from 'react';
import TableExtended from '@hubleto/react-ui/ext/TableExtended';

class TablePolicies extends TableExtended {
  static defaultProps = {
    ...TableExtended.defaultProps,
    formUseModalSimple: true,
    model: 'Hubleto/App/Custom/Insurance/Models/Policy'
  };

  constructor(props: any) {
    super(props);
    this.state = this.getStateFromProps(props);
  }
}

export default TablePolicies;
